<?php

namespace App\Http\Controllers;

use App\Models\DiscountDetail;
use App\Models\DiscountProduct;
use Illuminate\Http\Request;
use Exception;
use App\Models\Product;
use Carbon\Carbon;
use DateTime;

class DiscountController extends Controller
{
    // function __construct()
    // {
    //      $this->middleware('permission:Quản lý khuyến mại');
    // }
    public function index()
    {
        return view('admin.discount.Discount');
    }

    public function getPageData(Request $request){
        $searchText = $request->input('searchText', '');
        $pageNumber = $request->input('pageNumber', 1);
        $pageSize = $request->input('pageSize', 5);
        
        $query = DiscountProduct::query();
        if ($searchText) {
            $query->where('Name', 'LIKE', '%' . $searchText . '%');
        }

        $Data = $query->skip(($pageNumber - 1) * $pageSize)->take($pageSize)->get();
        $TotalCount = $query->count();
        
        return response()->json([
            'Data' => $Data,
            'TotalCount' =>$TotalCount
        ]); 
    }
    

     public function getProductOnly(Request $request){
        $searchText = $request->input('searchText', '');
        $pageNumber = $request->input('pageNumber', 1);
        $pageSize = $request->input('pageSize', 5);
        $query = Product::with(['ProductImages', 'ProductVariations']);

        if ($searchText) {
            $query->where('ProName', 'LIKE', '%' . $searchText . '%');
        }
    
        $TotalCount = $query->count();
        $products = $query->skip(($pageNumber - 1) * $pageSize)->take($pageSize)->get();

        $Data = $products->map(function ($p) {
            return [
                'ProId' => $p->ProId,
                'Price' => $p->Price,
                'ProName' => $p->ProName,
                'firstImage' => $p->ProductImages->first()->Image,
                'TotalQty' => $this->countTotalQuantity($p->ProductVariations->toArray()),
                'Check' => false
            ];
        })->toArray();

        return response()->json([
            'Data' => $Data,
            'TotalCount' =>$TotalCount
        ]); 
     }

     public function countTotalQuantity($list)
    {
        $total = 0;
        foreach ($list as $item) {
            $total += $item['Quantity'] - $item['Ordered'];
        }
        return $total;
    }


    /**Sử dụng để hiển thị lên khi sửa */
    public function getById($id){
        $dao = DiscountProduct::find($id);

        $dp = new DiscountProduct();
        $dp->DiscountProductId = $dao->DiscountProductId;
        $dp->Name = $dao->Name;
        $dp->StartDate = $dao->StartDate;
        $dp->EndDate = $dao->EndDate;
        $dp->DiscountDetails = $dao->DiscountDetails->map(function ($d) {
            $product = new Product();
            $product->ProId = $d->Product->ProId;
            $product->ProName = $d->Product->ProName;
            $product->Price = $d->Product->Price;
            $product->firstImage = $d->Product->ProductImages->first()->Image;
    
            return [
                'DiscountDetailId' => $d->DiscountDetailId,
                'Product' => $product,
                'priceAfter' => $this->countDiscountPrice($d->Product->Price, $d->Amount, $d->TypeAmount),
                'Amount' => $d->Amount,
                'TypeAmount' => $d->TypeAmount
            ];
        });
        return response()->json($dp);
    }

    
    public function countDiscountPrice($price, $amount, $typeAmount)
    {
        $discountPrice = 0;
        
        if ($typeAmount == "0") { //giảm giá theo tiền
            $discountPrice = $price - $amount;
        } else { //giảm giá theo %
            $discountPrice = round($price - (($amount / 100) * $price), 0);
        }
        
        return $discountPrice;
    }
    public function createView(){
        return view('admin.discount.Create');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {            
        $listDiscountDetail = json_decode($request->listDiscountDetail);
        $discountPro = new DiscountProduct;
        $discountPro->Name = $request->Name;
        $discountPro->StartDate = $request->StartDate ;
        $discountPro->EndDate = $request->EndDate;
        $discountPro->save();

        foreach ($listDiscountDetail as $item) {
            $dd = new DiscountDetail();
            $dd->ProId = $item->ProId;
            $dd->DiscountProductId =  $discountPro->DiscountProductId; 
            $dd->TypeAmount =  $item->TypeAmount; 
            $dd->Amount =  $item->Amount; 
            $dd->save();
        }
        return response()->json(true);
        try{


        }
        catch(Exception $e){
            return response()->json(false);
        }
    }

    public function updateView($id){
        return view('admin.discount.Update',['id'=>$id]);
    }
        /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $listDiscountDetail = json_decode($request->listDiscountDetail);
            $discountPro = DiscountProduct::find($id);
            $discountPro->Name = $request->Name;
            $discountPro->StartDate = Carbon::parse($request->StartDate);
            $discountPro->EndDate = Carbon::parse($request->EndDate);
            $discountPro->save();

            DiscountDetail::where('DiscountProductId',$id)->delete();
            foreach ($listDiscountDetail as $item) {
                $item->save();
            }

            return response()->json(true);
        }
        catch(Exception $e){
            return response()->json(false);
        }
        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try{
            DiscountDetail::where('DiscountProductId',$id)->delete();
            DiscountProduct::where('DiscountProductId',$id)->delete();
            return response()->json(true);
        }
        catch(Exception $e){
            return response()->json(true);

        }

    }
}
