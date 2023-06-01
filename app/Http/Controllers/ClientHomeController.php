<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCat;
use App\Models\DiscountDetail;
use App\Models\ProductImage;
use App\Models\ReportProduct;
use Carbon\Carbon;

class ClientHomeController extends BaseClietController
{
    public function HomeView(){
        $listDiscount = parent::getListDiscount();
        $listBestSale = parent::getListBestSale();
        $listNewProduct = parent::getlistNewProduct();
        
        $listPost = post::where('Status', true)
        ->orderByDesc('PublicDate')
        ->take(3)
        ->get();
        return view('client.index',['listDiscount'=>$listDiscount,'listBestSale'=>$listBestSale,'listNewProduct'=>$listNewProduct,'listPost'=>$listPost]);
    }

    public function ManView(){
        $listDiscount = parent::getListDiscount("Nam");
        $listBestSale = parent::getListBestSale("Nam");
        $listNewProduct = parent::getlistNewProduct("Nam");
        $ProductCats = ProductCat::with('Category')
        ->whereHas('Category', function ($query) {
            $query->where('type', 'Nam');
        })
        ->get();
        $Categories = Category::with('ProductCats')->where('type',"Nam")->get();
        return view('client.man',['listDiscount'=>$listDiscount,'listBestSale'=>$listBestSale,'listNewProduct'=>$listNewProduct,'ProductCats'=>$ProductCats,'Categories'=>$Categories]);
    }

    public function WomenView(){
        $listDiscount = parent::getListDiscount("Nữ");
        $listBestSale = parent::getListBestSale("Nữ");
        $listNewProduct = parent::getlistNewProduct("Nữ");
        $ProductCats = ProductCat::with('Category')
        ->whereHas('Category', function ($query) {
            $query->where('type', 'Nữ');
        })
        ->get();
        $Categories = Category::with('ProductCats')->where('type',"Nữ")->get();
        return view('client.women',['listDiscount'=>$listDiscount,'listBestSale'=>$listBestSale,'listNewProduct'=>$listNewProduct,'ProductCats'=>$ProductCats,'Categories'=>$Categories]);
    }

    public function BoyView(){
        $listDiscount = parent::getListDiscount("Bé trai");
        $listBestSale = parent::getListBestSale("Bé trai");
        $listNewProduct = parent::getlistNewProduct("Bé trai");
        $ProductCats = ProductCat::with('Category')
        ->whereHas('Category', function ($query) {
            $query->where('type', 'Bé trai');
        })
        ->get();
        $Categories = Category::with('ProductCats')->where('type',"Bé trai")->get();
        return view('client.baby-boy',['listDiscount'=>$listDiscount,'listBestSale'=>$listBestSale,'listNewProduct'=>$listNewProduct,'ProductCats'=>$ProductCats,'Categories'=>$Categories]);
    }

    public function GirlView(){
        $listDiscount = parent::getListDiscount("Bé gái");
        $listBestSale = parent::getListBestSale("Bé gái");
        $listNewProduct = parent::getlistNewProduct("Bé gái");
        $ProductCats = ProductCat::with('Category')
        ->whereHas('Category', function ($query) {
            $query->where('type', 'Bé gái');
        })
        ->get();
        $Categories = Category::with('ProductCats')->where('type',"Bé gái")->get();
        return view('client.baby-girl',['listDiscount'=>$listDiscount,'listBestSale'=>$listBestSale,'listNewProduct'=>$listNewProduct,'ProductCats'=>$ProductCats,'Categories'=>$Categories]);
    }

    public function detail($id)
    {
        $product = Product::with(['ProductVariations.ProductColor','ProductVariations.ProductSize','ProductImages','ProductCat', 'ProductVariations' => function ($query) {
            $query->where('Status', 1);}])->find($id);
        $firstProImage = $product->ProductImages->first();
        $currentDateTime = Carbon::now();
        $discountDetails = DiscountDetail::join('discountproduct', 'discountdetail.DiscountProductId', '=', 'discountproduct.DiscountProductId')
        ->where('discountproduct.StartDate', '<=', $currentDateTime)
        ->where('discountproduct.EndDate', '>=', $currentDateTime)
        ->orderByDesc('discountproduct.DiscountProductId')
        ->get();
        foreach ($discountDetails as $dt) {
            if ($dt->ProId == $product->ProId) {
                if ($dt->TyproducteAmount == "0") { // giảm giá theo tiền
                    $product->DiscountPrice = $product->Price - $dt->Amount;
                    $product->Percent = ($dt->Amount*100 / $product->Price);
                } else { // giảm giá theo %
                    $product->Percent = $dt->Amount;
                    $product->DiscountPrice = round($product->Price - (($dt->Amount / 100) * $product->Price), 0);
                }
                break;
            }
        }
        // Lấy 10 sản phẩm cùng loại
        
        $relatedList = Product::with(['ProductCat', 'ProductVariations' => function ($query) {
            $query->where('Status', 1);}])->whereHas('ProductCat', function ($query) use ($product) {
            $query->where('ProCatId', $product->ProCatId);
        })->get();
        foreach ($relatedList as $p) {
            foreach ($discountDetails as $dt) {
                if ($dt->ProId == $p->ProId) {
                    if ($dt->TypeAmount == "0") { // giảm giá theo tiền
                        $p->DiscountPrice = $p->Price - $dt->Amount;
                        $p->Percent = ($dt->Amount*100 / $p->Price);
                    } else { // giảm giá theo %
                        $p->Percent = $dt->Amount;
                        $p->DiscountPrice = round($p->Price - (($dt->Amount / 100) * $p->Price), 0);
                    }
                    break;
                }
            }
        }
        $saled = ReportProduct::where('ProId',$id)->sum('Quantity');
        return view('client.product-detail', ['saled'=>$saled,'RelatedProduct'=>$relatedList,'product'=>$product,'firstProImage'=>$firstProImage]);
    }

    public function filterOutlet(Request $request)
    {
        $o = $request->input('o');
        $minMoney = json_decode($request->input('minMoney'));
        $maxMoney = json_decode($request->input('maxMoney'));
        
        if ($o == 'All') {
            $products = Product::with(['ProductVariations' => function ($query) {
                $query->where('Status', 1);},'ProductVariations.ProductColor','ProductVariations.ProductSize','ProductImages','ProductImages.ProductColor'])->join('discountdetail', 'product.ProId', '=', 'discountdetail.ProId')
            ->join('discountproduct', 'discountdetail.DiscountProductId', '=', 'discountproduct.DiscountProductId')
            ->where('discountproduct.StartDate', '<=', Carbon::now())
            ->where('discountproduct.EndDate', '>=', Carbon::now())
            ->orderBy('discountproduct.DiscountProductId', 'desc') //giảm dần để khi lọc product thì lấy cái mới nhất
            ->select('product.ProId', 'product.ProName','product.Price','discountdetail.Amount as Amount','discountdetail.TypeAmount as TypeAmount')
            ->get();
        
        } else {
            $products = Product::with(['ProductVariations' => function ($query)  {
                $query->where('Status', 1);},'ProductVariations.ProductColor','ProductVariations.ProductSize','ProductImages','ProductImages.ProductColor'])->whereHas('productcat.category', function ($query) use ($o) {
                $query->where('type', $o);
            })
            ->join('discountdetail', 'product.ProId', '=', 'discountdetail.ProId')
            ->join('discountproduct', 'discountdetail.DiscountProductId', '=', 'discountproduct.DiscountProductId')
            ->where('discountproduct.StartDate', '<=', Carbon::now())
            ->where('discountproduct.EndDate', '>=', Carbon::now())
            ->orderBy('discountproduct.DiscountProductId', 'desc') //giảm dần để khi lọc product thì lấy cái mới nhất
            ->select('product.ProId', 'product.ProName','product.Price','discountdetail.Amount as Amount','discountdetail.TypeAmount as TypeAmount')
            ->get();        
        }

        //filter same product
        $uniqueProducts = collect([]);
        $uniqueProIds = [];
        foreach ($products as $product) {
            if (!in_array($product->ProId, $uniqueProIds)) {
                if ($product->TypeAmount == "0") { // giảm giá theo tiền
                    $product->DiscountPrice = $product->Price - $product->Amount;
                    $product->Percent = ($product->Amount / $product->Price)*100;
                } else { // giảm giá theo %
                    $product->Percent = $product->Amount;
                    $product->DiscountPrice = round($product->Price - (($product->Amount / 100) * $product->Price), 0);
                }
                
                if($product->DiscountPrice >=$minMoney && $product->DiscountPrice <=$maxMoney){
                    $uniqueProducts->push($product);
                }
                $uniqueProIds[] = $product->ProId;
            }
        }
    
        return response()->json($uniqueProducts);
    }
    
}
