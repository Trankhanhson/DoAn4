<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductCat;
use App\Models\ProductColor;
use App\Models\Product;
class ShowCatController extends ClientHomeController
{
    public function showCat($id){
        $category = Category::find($id);
        $Categories = Category::where("type",$category->type)->get();
        $listColor = ProductColor::all();
        return view('client.showCat.show-category',['category'=>$category,'Categories'=>$Categories,'catId'=>$id,'listColor'=>$listColor]);
    }

    
    public function getCatData(Request $request)
    {
        $catId =  $request->CatId;
        $colorId = json_decode($request->input('colorId'));
        $minPrice = json_decode($request->input('minPrice'));
        $maxPrice = json_decode($request->input('maxPrice'));
        $pageNumber = $request->pageNumber;
        $pageSize = $request->pageSize;

        $query = Product::with(['ProductVariations.ProductColor','ProductVariations.ProductSize','ProductImages.ProductColor','ProductCat', 'ProductVariations' => function ($query) {
            $query->where('Status', 1);}])->whereHas('ProductCat', function ($query) use ($catId) {
            $query->where('CatID', $catId);})->get();
        $listProduct = parent::getDiscountFromList($query);
        $listResult = collect([]);
        if ($colorId == 0 && $minPrice !== -1 && $maxPrice !== -1) {
            
            //chỉ tìm giá
            foreach($listProduct as $item){
                if ($item->DiscountPrice > 0)
                {
                    if($item->DiscountPrice >= $minPrice && $item->DiscountPrice <= $maxPrice)
                    {
                        $listResult->Add($item);
                    }
                }
                else
                {
                    if ($item->Price >= $minPrice && $item->Price <= $maxPrice)
                    {
                        $listResult->Add($item);
                    }
                }
            }
        } elseif ($colorId !== 0 && $minPrice !== -1 && $maxPrice !== -1) {
            foreach($listProduct as $item){
                if ($item->DiscountPrice > 0)
                {
                    if($item->DiscountPrice >= $minPrice && $item->DiscountPrice <= $maxPrice && $item->ProductVariations->where("ProColorID",$colorId)->first()!=null)
                    {
                        $listResult->Add($item);
                    }
                }
                else
                {
                    if ($item->Price >= $minPrice && $item->Price <= $maxPrice && $item->ProductVariations->where("ProColorID",$colorId)->first()!=null)
                    {
                        $listResult->Add($item);
                    }
                }
            }

        } elseif ($colorId !== 0 && $minPrice === -1 && $maxPrice === -1) {
            foreach($listProduct as $item){
                $check = $item->ProductVariations->where('ProColorID',$colorId)->first();
                if($check !=null){
                    $listResult->Add($item);
                }
             }
        }
        else{
           $listResult = $listProduct;
        }
            $products = array_slice($listResult->toArray(), ($pageNumber - 1) * $pageSize, $pageSize);
            $total = count($listResult);

        // Perform additional operations on $products if needed
        $result = [
            'TotalCount' => $total,
            'Data' => $products,
        ];

        return response()->json($result);
    }

    public function showProCat($id){
        $procat = ProductCat::find($id);
        $Categories = Category::where("type",$procat->Category->type)->get();
        $listColor = ProductColor::all();
        return view('client.showCat.show-procat',['proCatId'=>$id,'procat'=>$procat,'Categories'=>$Categories,'listColor'=>$listColor]);
     }

     public function getProCatData(Request $request)
     {
        $ProCatId = $request->input('ProCatId');
         $colorId = json_decode($request->input('colorId'));
         $minPrice = json_decode($request->input('minPrice'));
         $maxPrice = json_decode($request->input('maxPrice'));
         $pageNumber = $request->input('pageNumber', 1);
         $pageSize = $request->input('pageSize', 20);
 
         $query = Product::with(['ProductVariations.ProductColor','ProductVariations.ProductSize','ProductImages.ProductColor','ProductCat', 'ProductVariations' => function ($query) {
            $query->where('Status', 1);}])->where('ProCatId',$ProCatId)->get();
         $listProduct = parent::getDiscountFromList($query);
         $listResult = collect([]);
         if ($colorId == 0 && $minPrice !== -1 && $maxPrice !== -1) {
            
             //chỉ tìm giá
             foreach($listProduct as $item){
                 if ($item->DiscountPrice > 0)
                 {
                     if($item->DiscountPrice >= $minPrice && $item->DiscountPrice <= $maxPrice)
                     {
                         $listResult->Add($item);
                     }
                 }
                 else
                 {
                     if ($item->Price >= $minPrice && $item->Price <= $maxPrice)
                     {
                         $listResult->Add($item);
                     }
                 }
             }
         } elseif ($colorId !== 0 && $minPrice !== -1 && $maxPrice !== -1) {
             foreach($listProduct as $item){
                 if ($item->DiscountPrice > 0)
                 {
                     if($item->DiscountPrice >= $minPrice && $item->DiscountPrice <= $maxPrice && $item->ProductVariations->where("ProColorID",$colorId)->first()!=null)
                     {
                         $listResult->Add($item);
                     }
                 }
                 else
                 {
                     if ($item->Price >= $minPrice && $item->Price <= $maxPrice && $item->ProductVariations->where("ProColorID",$colorId)->first()!=null)
                     {
                         $listResult->Add($item);
                     }
                 }
             }
 
         } elseif ($colorId !== 0 && $minPrice === -1 && $maxPrice === -1) {
            foreach($listProduct as $item){
                $check = $item->ProductVariations->where('ProColorID',$colorId)->first();
                if($check !=null){
                    $listResult->Add($item);
                }
             }
         }
         else{
            $listResult = $listProduct;
         }
         
         $products = array_slice($listResult->toArray(), ($pageNumber - 1) * $pageSize, $pageSize);
         $total = count($listResult);
         
         // Perform additional operations on $products if needed
         $result = [
             'Total' => $total,
             'Data' => $products,
         ];
 
         return response()->json($result);
     }
}
