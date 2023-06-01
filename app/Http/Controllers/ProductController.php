<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductCat;
use App\Models\ProductColor;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Exception;
class ProductController extends Controller
{

    public function index(){
        return view('admin.product.Product');
    }

    public function getSearchData(Request $request)
    {
        $searchText = $request->input('searchText');
        $result = "";
        $check = false;
        if (trim($searchText)) {
            $products = Product::where(function ($query) use ($searchText) {
                $query->where(DB::raw('LOWER(ProName)'), 'like', '%' . $searchText . '%')
                      ->orWhereHas('productCat.category', function ($query) use ($searchText) {
                          $query->where('type', 'like', '%' . $searchText . '%');
                      });
            })->select('ProId', 'ProCatId', 'ProName', 'Price', 'ImportPrice','Status')
              ->with(['ProductCat', 'ProductVariations' => function ($query) {
                  $query->where('Status', 1) ->select('ProVariationID', 'ProId', 'ProSizeID', 'ProColorID', 'Quantity','DisplayImage')
                        ->with(['ProductColor' => function ($query) {
                            $query->select('ProColorID', 'NameColor', 'ImageColor');
                        }, 'ProductSize' => function ($query) {
                            $query->select('ProSizeID', 'NameSize');
                        }]);
              }])
              ->get();
              
            // Convert to JSON
            $result = $products->toJson();
            $check = true;
        }
        else{
            $products = Product::select('ProId', 'ProCatId', 'ProName', 'Price', 'ImportPrice','Status')
              ->with(['ProductCat', 'ProductVariations' => function ($query) {
                  $query->where('Status', 1)->select('ProVariationID', 'ProId', 'ProSizeID', 'ProColorID', 'Quantity','DisplayImage')
                        ->with(['ProductColor' => function ($query) {
                            $query->select('ProColorID', 'NameColor', 'ImageColor');
                        }, 'ProductSize' => function ($query) {
                            $query->select('ProSizeID', 'NameSize');
                        }]);
              }])->whereHas('ProductVariations', function ($query) {
                $query->where('Status', true);
            })
              ->get();
              
            // Convert to JSON
            $result = $products->toJson();
            $check = true;
        }
    
        return response()->json([
            'check' => $check,
            'result' => $result
        ]);
    }

    public function getSearchDataClient(Request $request)
    {
        $searchText = $request->searchText;
        $result = "";
        $check = false;
        if (trim($searchText) != "") {
            $products = Product::where(function ($query) use ($searchText) {
                $query->where(DB::raw('LOWER(ProName)'), 'like', '%' . $searchText . '%');
                })
                ->select('ProId', 'ProName', 'Price',)
                ->with('productImages')
                ->where('Status', 1)
                ->get();

            $products = $products->map(function ($product) {
                $product->firstImage = $product->ProductImages->first()->Image;
                unset($product->ProductImages);
                return $product;
            });

            $result = $products->toJson();
            $check = true;
        }

        return response()->json([
            'check' => $check,
            'result' => $result
        ])->header('Content-Type', 'application/json');
    }

    public function getPageData(Request $request)
    {
        $searchText = $request->input('searchText', '');
        $pageNumber = $request->input('pageNumber', 1);
        $pageSize = $request->input('pageSize', 5);
        $getMinimum = $request->input('getMinimum');
        $productGets = Product::with(['ProductCat', 'ProductVariations.ProductColor', 'ProductVariations.ProductSize', 'ProductVariations'=> function ($query) {
            $query->where('Status', 1);
        }])
        ->orderByDesc('created_at')
        ->select('ProId', 'ProCatId', 'ProName', 'Price', 'ImportPrice','Status')
        ->get();
        
        $products =  collect([]);
        if($getMinimum == 1){
            
            foreach($productGets as $p){
                $filteredProductVariations = $p->ProductVariations->filter(function ($pv) {
                    return $pv->MinimumQuantity >= $pv->Quantity;
                });
                
                $p->ProductVariations = $filteredProductVariations;

                if($p->ProductVariations->count() > 0){
                    $products->push($p);
                }
                
            }
        }
        else{
            $products = $productGets;
        }

        if (trim($searchText) !== '') {
            $products = $products->filter(function ($product) use ($searchText) {
                return stripos($product->ProName, $searchText) !== false;
            });
        }

        $Data = array_slice($products->toArray(), ($pageNumber - 1) * $pageSize, $pageSize);
        $TotalCount = count($products);

        return response()->json([
            'Data' => $Data,
            'TotalCount' =>$TotalCount
        ]);
    }

    public function createView(){
        $CatList = Category::all(['CatID','Name','type']);
        return view('admin.product.CreateProduct',['CatList'=>$CatList]);
    }

    public function create(Request $request){
        $product = json_decode($request->product);
        $p = new Product();
        $p->ProCatId = $product->ProCatId;
        $p->ProName = $product->ProName;
        $p->Material = $product->Material;
        $p->Description = $product->Description;
        $p->Price = $product->Price;
        $p->ImportPrice = $product->ImportPrice;
        $p->save();
        foreach($product->listVariation as $item){
            $pv = new ProductVariation();
            $pv->ProId = $p->ProId;
            $pv->ProSizeID = $item->ProSizeID;
            $pv->ProColorID = $item->ProColorID;
            $pv->Quantity = 0;
            $pv->MinimumQuantity = $item->MinimumQuantity;
            $pv->save();
        }
        return response()->json($p);
    }

    public function updateView($id){
        $CatList = Category::all(['CatID','Name','type']);
        $product = Product::with(['ProductCat','ProductImages.ProductColor','ProductVariations.ProductColor','ProductVariations.ProductSize', 'ProductVariations'=> function ($query) {
            $query->where('Status', 1);
        }])->where('ProId',$id)->first();
        return view('admin.product.EditProduct',['CatList'=>$CatList,'product'=>$product]);
    }

    public function update(Request $request){
        $product = json_decode($request->product);
        $productRes = Product::with('ProductVariations')->find($product->ProId);
        $productRes->ProName = $product->ProName;
        $productRes->ProCatId = $product->ProCatId;
        $productRes->Material = $product->Material;
        $productRes->Description = $product->Description;
        $productRes->Price = $product->Price;
        $productRes->ImportPrice = $product->ImportPrice;
        $productRes->save();
        $listVariation = Collection::make($product->listVariation);
        //sửa variation
        foreach($productRes->ProductVariations as $pv){
            
            $pvf = $listVariation->where("ProSizeID",$pv->ProSizeID)->where("ProColorID",$pv->ProColorID)->first();
            if($pvf !=null){
                $pv->MinimumQuantity = $pvf->MinimumQuantity;
            }
            else{
                $pv->Status = false;
            }
            $pv->save();
        }

        foreach($listVariation as $pv){
            $pvf = $productRes->ProductVariations->where("ProSizeID",$pv->ProSizeID)->where("ProColorID",$pv->ProColorID)->first();
            if($pvf ==null){
                $pvNew = new ProductVariation();
                $pvNew->ProId = $productRes->ProId;
                $pvNew->ProSizeID = $pv->ProSizeID;
                $pvNew->ProColorID = $pv->ProColorID;
                $pvNew->Quantity = 0;
                $pvNew->MinimumQuantity = $pv->MinimumQuantity;
                $pvNew->save();
            }
        }


        //xóa các đối tượng ProductImage bị người dùng xóa trên giao diện
        $listOldImage = ProductImage::where('ProId',$product->ProId)->get();
        foreach ($listOldImage as $image) {
            $vari = $listVariation->where('ProColorID',$image->ProColorID)->first();
            // Trong danh sách không còn màu này nữa => đã xóa các biến thể của màu này
            if ($vari === null) {
                $pathDelete = storage_path('app/public/uploads/Product');
                if ($image->Image != "") {
                    if(File::exists($pathDelete.'/'.$image->Image)){
                        File::delete($pathDelete.'/'.$image->Image);
                    }
                }
                if ($image->DetailImage1 != "") {
                    if(File::exists($pathDelete.'/'.$image->DetailImage1)){
                        File::delete($pathDelete.'/'.$image->DetailImage1);
                    }
                }
                if ($image->DetailImage2 != "") {
                    if(File::exists($pathDelete.'/'.$image->DetailImage2)){
                        File::delete($pathDelete.'/'.$image->DetailImage2);
                    }
                }
                if ($image->DetailImage3 != "") {
                    if(File::exists($pathDelete.'/'.$image->DetailImage3)){
                        File::delete($pathDelete.'/'.$image->DetailImage3);
                    }
                }
                if ($image->DetailImage4 != "") {
                    if(File::exists($pathDelete.'/'.$image->DetailImage4)){
                        File::delete($pathDelete.'/'.$image->DetailImage4);
                    }
                }
                if ($image->DetailImage5 != "") {
                    if(File::exists($pathDelete.'/'.$image->DetailImage5)){
                        File::delete($pathDelete.'/'.$image->DetailImage5);
                    }
                }
                
                $image->delete();
            }
        }
    }

    public function destroy($id){
        try{
            ProductVariation::where('ProId',$id)->delete();

            $listImages = ProductImage::where('ProId',$id)->get();
            $this->deleteImage($listImages);
            Product::where('ProId',$id)->delete();
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    public function destroyVariation($id){
        ProductVariation::where('ProVariationID',$id)->delete();
    }

    public function deleteImage($listImage){
        foreach ($listImage as $image) {
            $pathDelete = storage_path('app/public/uploads/Product');
            if ($image['Image'] != "") {
                if(File::exists($pathDelete.'/'.$image['Image'])){
                    File::delete($pathDelete.'/'.$image['Image']);
                }
            }
            if ($image['DetailImage1'] != "") {
                if(File::exists($pathDelete.'/'.$image['DetailImage1'])){
                    File::delete($pathDelete.'/'.$image['DetailImage1']);
                }
            }
            if ($image['DetailImage2'] != "") {
                if(File::exists($pathDelete.'/'.$image['DetailImage2'])){
                    File::delete($pathDelete.'/'.$image['DetailImage2']);
                }
            }
            if ($image['DetailImage3'] != "") {
                if(File::exists($pathDelete.'/'.$image['DetailImage3'])){
                    File::delete($pathDelete.'/'.$image['DetailImage3']);
                }
            }
            if ($image['DetailImage4'] != "") {
                if(File::exists($pathDelete.'/'.$image['DetailImage4'])){
                    File::delete($pathDelete.'/'.$image['DetailImage4']);
                }
            }
            if ($image['DetailImage5'] != "") {
                if(File::exists($pathDelete.'/'.$image['DetailImage5'])){
                    File::delete($pathDelete.'/'.$image['DetailImage5']);
                }
            }
            
            $image->delete();
        }
    }

    public function uploadProImg(Request $request)
    {
        $proImage = new ProductImage;
        $proImage->ProId = $request->ProId;
        $proImage->ProColorID = $request->ProColorID;


        if ($request->hasFile('ImageFile')) {
            $file = $request->file('ImageFile');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $file->storeAs('public/uploads/Product', $fileName);
            $proImage->Image = $fileName;

            DB::table('productvariation')->where('ProId',$request->ProId)
            ->where('ProColorID',$request->ProColorID)->update(['DisplayImage'=>$fileName]);
        }

        if ($request->hasFile('DetailImage1File')) {
            $file1 = $request->file('DetailImage1File');
            $extension = $file1->getClientOriginalExtension();
            $fileName1 = Str::random(40) . '.' . $extension;
            $file1->storeAs('public/uploads/Product', $fileName1);
            $proImage->DetailImage1 = $fileName1;
        }
        if ($request->hasFile('DetailImage2File')) {
            $file2 = $request->file('DetailImage2File');
            $extension = $file2->getClientOriginalExtension();
            $fileName2 = Str::random(40) . '.' . $extension;
            $file2->storeAs('public/uploads/Product', $fileName2);
            $proImage->DetailImage2 = $fileName2;
        }
        if ($request->hasFile('DetailImage3File')) {
            $file3 = $request->file('DetailImage3File');
            $extension = $file3->getClientOriginalExtension();
            $fileName3 = Str::random(40) . '.' . $extension;
            $file3->storeAs('public/uploads/Product', $fileName3);
            $proImage->DetailImage3 = $fileName3;
        }
        if ($request->hasFile('DetailImage4File')) {
            $file4 = $request->file('DetailImage4File');
            $extension = $file4->getClientOriginalExtension();
            $fileName4 = Str::random(40) . '.' . $extension;
            $file4->storeAs('public/uploads/Product', $fileName4);
            $proImage->DetailImage4 = $fileName4;
        }
        if ($request->hasFile('DetailImage5File')) {
            $file5 = $request->file('DetailImage5File');
            $extension = $file5->getClientOriginalExtension();
            $fileName5 = Str::random(40) . '.' . $extension;
            $file5->storeAs('public/uploads/Product', $fileName5);
            $proImage->DetailImage5 = $fileName5;
        }

        $proImage->save();
    }

    public function uploadUpdateProImg(Request $request)
    {
        $pathLocal = storage_path('app/public/uploads/Product');
        $proImage = ProductImage::where('ProColorID',$request->ProColorID)->where('ProId',$request->ProId)->first();
        // Image
        // Add new image
        if ($request->input('StatusImage') == 1) {
            // Delete old image
            if (!empty($request->input('Image'))) {
                File::delete($pathLocal.'/'.$request->input('Image'));
            }
            $file = $request->file('ImageFile');
            // Update new image
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $file->storeAs('public/uploads/Product', $fileName);
            $proImage->Image = $fileName;
            DB::table('productvariation')->where('ProId',$request->ProId)
            ->where('ProColorID',$request->ProColorID)->update(['DisplayImage'=>$fileName]);
        }
        // Delete old image without adding new image
        else if ($request->input('StatusImage') == 2) {
            if (!empty($request->input('Image'))) {
                File::delete($pathLocal.'/'.$request->input('Image'));
            }

            $proImage->Image = "";
            DB::table('productvariation')->where('ProId',$request->ProId)
            ->where('ProColorID',$request->ProColorID)->update(['DisplayImage'=>""]);
        }

        //DetailImage1
        if ($request->input('StatusDetailImage1') == 1) {
            // Delete old image
            if (!empty($request->input('DetailImage1'))) {
                File::delete($pathLocal.'/'.$request->input('DetailImage1'));
            }
            $file1 = $request->file('DetailImage1File');
            // Update new image
            $extension = $file1->getClientOriginalExtension();
            $fileName1 = Str::random(40) . '.' . $extension;
            $file1->storeAs('public/uploads/Product', $fileName1);
            $proImage->DetailImage1 = $fileName1;
        }
        // Delete old image without adding new image
        else if ($request->input('StatusDetailImage1') == 2) {
            if (!empty($request->input('DetailImage1'))) {
                File::delete($pathLocal.'/'.$request->input('DetailImage1'));
            }

            $proImage->DetailImage1 = "";
        }

        //DetailImage2
        if ($request->input('StatusDetailImage2') == 1) {
            // Delete old image
            if (!empty($request->input('DetailImage2'))) {
                File::delete($pathLocal.'/'.$request->input('DetailImage2'));
            }
            $file2 = $request->file('DetailImage2File');
            // Update new image
            $extension = $file2->getClientOriginalExtension();
            $fileName2 = Str::random(40) . '.' . $extension;
            $file2->storeAs('public/uploads/Product', $fileName2);
            $proImage->DetailImage2 = $fileName2;
        }
        // Delete old image without adding new image
        else if ($request->input('StatusDetailImage2') == 2) {
            if (!empty($request->input('DetailImage2'))) {
                File::delete($pathLocal.'/'.$request->input('DetailImage2'));
            }

            $proImage->DetailImage2 = "";
        }

        //DetailImage3
        if ($request->input('StatusDetailImage3') == 1) {
            // Delete old image
            if (!empty($request->input('DetailImage3'))) {
                File::delete($pathLocal.'/'.$request->input('DetailImage3'));
            }
            $file3 = $request->file('DetailImage3File');
            // Update new image
            $extension = $file3->getClientOriginalExtension();
            $fileName3 = Str::random(40) . '.' . $extension;
            $file3->storeAs('public/uploads/Product', $fileName3);
            $proImage->DetailImage3 = $fileName3;
        }
        // Delete old image without adding new image
        else if ($request->input('StatusDetailImage3') == 2) {
            if (!empty($request->input('DetailImage3'))) {
                File::delete($pathLocal.'/'.$request->input('DetailImage3'));
            }

            $proImage->DetailImage3 = "";
        }

        //DetailImage4
        if ($request->input('StatusDetailImage4') == 1) {
            // Delete old image
            if (!empty($request->input('DetailImage4'))) {
                File::delete($pathLocal.'/'.$request->input('DetailImage4'));
            }
            $file4 = $request->file('DetailImage4File');
            // Update new image
            $extension = $file4->getClientOriginalExtension();
            $fileName4 = Str::random(40) . '.' . $extension;
            $file4->storeAs('public/uploads/Product', $fileName4);
            $proImage->DetailImage4 = $fileName4;
        }
        // Delete old image without adding new image
        else if ($request->input('StatusDetailImage4') == 2) {
            if (!empty($request->input('DetailImage4'))) {
                File::delete($pathLocal.'/'.$request->input('DetailImage4'));
            }

            $proImage->DetailImage4 = "";
        }

        //DetailImage5
        if ($request->input('StatusDetailImage5') == 1) {
            // Delete old image
            if (!empty($request->input('DetailImage5'))) {
                File::delete($pathLocal.'/'.$request->input('DetailImage5'));
            }
            $file5 = $request->file('DetailImage5File');
            // Update new image
            $extension = $file5->getClientOriginalExtension();
            $fileName5 = Str::random(40) . '.' . $extension;
            $file5->storeAs('public/uploads/Product', $fileName5);
            $proImage->DetailImage5 = $fileName5;
        }
        // Delete old image without adding new image
        else if ($request->input('StatusDetailImage5') == 2) {
            if (!empty($request->input('DetailImage5'))) {
                File::delete($pathLocal.'/'.$request->input('DetailImage5'));
            }

            $proImage->DetailImage5 = "";
        }


        $proImage->save();
    }

    public function changeStatus($id){
        $p = Product::find($id);
        $p->Status = !$p->Status;
        $p->save();
    }

}
