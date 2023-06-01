<?php

namespace App\Http\Controllers;

use App\Models\ProductCat;
use App\Models\Category;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductCatController extends Controller
{
    // function __construct()
    // {
    //      $this->middleware('permission:Quản lý loại sản phẩm');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $CatList = Category::all(['CatID','Name','type']);
        return view('admin.ProductCat',['CatList'=>$CatList]);
    }

    public function getPageData(Request $request){
        $searchText = $request->input('searchText', '');
        $pageNumber = $request->input('pageNumber', 1);
        $pageSize = $request->input('pageSize', 5);
        if ($searchText)
        {
            $productCats = ProductCat::with('category')->where('Name', 'LIKE', '%' . $searchText . '%')->get();
        }
        else{
            $productCats = ProductCat::with('category')->get();
        }

        $Data = array_slice($productCats->toArray(), ($pageNumber - 1) * $pageSize, $pageSize);
        $TotalCount = count($productCats);
        $firstCatId = Category::first();
        return response()->json([
            'Data' => $Data,
            'TotalCount' =>$TotalCount,
            'firstCatId' =>$firstCatId->CatID
        ]); 
     }

    public function getById($id){
        $procat = ProductCat::with('category')->where('ProCatId',$id)->first();
        
        return response()->json($procat);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try{
            $procat = new ProductCat;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $fileName = Str::random(40) . '.' . $extension;
                $file->storeAs('public/uploads/ProductCat', $fileName);
                $procat->Image = $fileName;
            }
            $procat->Name = $request->Name;
            $procat->CatID = $request->CatID;
            $procat->Active = 1;
            $procat->save();
            $procat->load('category');
            return response()->json([
                'check' => true,
                'pc' => $procat
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'check' => false
            ]);
        }
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCat  $ProductCat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $updateSuccess = true;
            $objectData = json_decode($request->proCat);
            $procat = ProductCat::find($id);
            if ($request->hasFile('file')) {
                //delete old file if user upload new file
                $oldPath = storage_path('app/public/uploads/ProductCat/'.$procat->Image);
                if(File::exists($oldPath)){
                    File::delete($oldPath);
                }
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $fileName = Str::random(40) . '.' . $extension;
                $file->storeAs('public/uploads/ProductCat', $fileName);
                $procat->Image = $fileName;
            }
            $procat->Name = $objectData->Name;
            $procat->CatID = $objectData->CatID;
            $procat->Active = $objectData->Active;
            $procat->save();
            $procat->load('category');
        return response()->json([
            'check' => $updateSuccess,
            'procat'=>$procat
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCat  $ProductCat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = "";
        $check = true;
        try{
            $procat = ProductCat::findOrFail($id);
            $path = storage_path('app/public/uploads/ProductCat/'.$procat->Image);
            if (File::exists($path)) {
                // Nếu ảnh cũ chưa tồn tại, xóa ảnh cũ để thêm ảnh mới
                File::delete($path);
            }
            $procat->delete();
            $message="Xóa thành công";
        }
        catch(Exception $e){
            $check = false;
            $message = "xóa thất bại";
        }

        return response()->json([
            'message'=>$message,
            'check' =>$check
        ]);
    }

    public function changeStatus($id){
        $procat = ProductCat::findOrFail($id);
        $procat->Active = !$procat->Active;
        $procat->save();
    }
}
