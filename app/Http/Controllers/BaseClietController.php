<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscountDetail;
use Carbon\Carbon;
use App\Models\Product;

class BaseClietController extends Controller
{
    public function getListDiscount($type = "")
    {
        if($type){
            $products = Product::with(['ProductVariations' => function ($query) {
                $query->where('Status', 1);}])->whereHas('productcat.category', function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->join('discountdetail', 'product.ProId', '=', 'discountdetail.ProId')
            ->join('discountproduct', 'discountdetail.DiscountProductId', '=', 'discountproduct.DiscountProductId')
            ->where('discountproduct.StartDate', '<=', Carbon::now())
            ->where('discountproduct.EndDate', '>=', Carbon::now())
            ->orderBy('discountproduct.DiscountProductId', 'desc') //giảm dần để khi lọc product thì lấy cái mới nhất
            ->select('product.ProId', 'product.ProName','product.Price','discountdetail.Amount as Amount','discountdetail.TypeAmount as TypeAmount')
            ->get();        
        }
        else{
            $products = Product::with(['ProductVariations' => function ($query) {
                $query->where('Status', 1);}])->join('discountdetail', 'product.ProId', '=', 'discountdetail.ProId')
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
                $uniqueProducts->push($product);
                
                $uniqueProIds[] = $product->ProId;
            }
        }

        return $uniqueProducts;

    }

    public function getListBestSale($type = ""){
        $currentDateTime = Carbon::now();

        $discountDetails = DiscountDetail::join('discountproduct', 'discountdetail.DiscountProductId', '=', 'discountproduct.DiscountProductId')
            ->where('discountproduct.StartDate', '<=', $currentDateTime)
            ->where('discountproduct.EndDate', '>=', $currentDateTime)
            ->orderByDesc('discountproduct.DiscountProductId')
            ->get();
        if($type){
            $products = Product::with(['ProductVariations' => function ($query) {
                $query->where('Status', 1);}])->whereHas('ProductCat.Category', function ($query) use ($type) {
                $query->where('type', $type);
            })->orderByDesc('Saled')->take(8)->get();    
        }
        else{
            $products = Product::with(['ProductVariations' => function ($query) {
                $query->where('Status', 1);}])->orderByDesc('Saled')->take(8)->get();
        }

        foreach ($products as $p) {
            
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

        return $products;
    }

    public function getlistNewProduct($type = ""){
        $currentDateTime = Carbon::now();

        $discountDetails = DiscountDetail::join('discountproduct', 'discountdetail.DiscountProductId', '=', 'discountproduct.DiscountProductId')
            ->where('discountproduct.StartDate', '<=', $currentDateTime)
            ->where('discountproduct.EndDate', '>=', $currentDateTime)
            ->orderByDesc('discountproduct.DiscountProductId')
            ->get();
        if($type){
            $products = Product::with(['ProductVariations' => function ($query) {
                $query->where('Status', 1);}])->whereHas('ProductCat.Category', function ($query) use ($type) {
                $query->where('type', $type);
            })->orderByDesc('ImportDate')->take(8)->get();    
        }
        else{
            $products = Product::with(['ProductVariations' => function ($query) {
                $query->where('Status', 1);}])->orderByDesc('ImportDate')->take(8)->get();
        }

        foreach ($products as $p) {
            
            foreach ($discountDetails as $dt) {
                if ($dt->ProId == $p->ProId) {
                    if ($dt->TypeAmount == "0") { // giảm giá theo tiền
                        $p->DiscountPrice = $p->Price - $dt->Amount;
                        $p->Percent = ($dt->Amount / $p->Price)*100;
                    } else { // giảm giá theo %
                        $p->Percent = $dt->Amount;
                        $p->DiscountPrice = round($p->Price - (($dt->Amount / 100) * $p->Price), 0);
                    }
                    break;
                }
            }
        }
        return $products;
    }

    public function getDiscountFromList($list){
        $currentDateTime = Carbon::now();
        $discountDetails = DiscountDetail::join('discountproduct', 'discountdetail.DiscountProductId', '=', 'discountproduct.DiscountProductId')
        ->where('discountproduct.StartDate', '<=', $currentDateTime)
        ->where('discountproduct.EndDate', '>=', $currentDateTime)
        ->orderByDesc('discountproduct.DiscountProductId')
        ->get();

        foreach ($list as $p) {
            
            foreach ($discountDetails as $dt) {
                if ($dt->ProId == $p->ProId) {
                    if ($dt->TypeAmount == "0") { // giảm giá theo tiền
                        $p->DiscountPrice = $p->Price - $dt->Amount;
                        $p->Percent = ($dt->Amount / $p->Price)*100;
                    } else { // giảm giá theo %
                        $p->Percent = $dt->Amount;
                        $p->DiscountPrice = round($p->Price - (($dt->Amount / 100) * $p->Price), 0);
                    }
                    break;
                }
            }
        }

        return $list;
    }
}
