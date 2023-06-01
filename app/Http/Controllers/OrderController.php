<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Statistical;
use Carbon\Carbon;
use App\Models\ProductVariation;
use App\Models\ReportProduct;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function WaitProcess(){
        return view('admin.order.WaitProcess');
    }
    public function Tranfering(){
        return view('admin.order.Tranfering');
    }
    public function Success(){
        return view('admin.order.Success');
    }
    public function Canceled(){
        return view('admin.order.Canceled');
    }
    public function getPageData(Request $request){
        $searchText = $request->input('searchText', '');
        $statusId = $request->input('statusId');
        $pageNumber = $request->input('pageNumber', 1);
        $pageSize = $request->input('pageSize', 5);
        
        $query = Order::where('StatusOrderId',$statusId)->orderByDesc('OrderDate');
        if ($searchText) {
            $query->where('ReceivingPhone', 'LIKE', '%' . $searchText . '%');
        }

        $Data = $query->skip(($pageNumber - 1) * $pageSize)->take($pageSize)->get();
        $TotalCount = $query->count();
        
        return response()->json([
            'Data' => $Data,
            'TotalCount' =>$TotalCount
        ]); 
    }

    public function delete($id)
    {
        try {
            Order::where('id', $id)->delete();
            return response()->json(true);
        } catch (\Exception $ex) {
            return response()->json(false);
        }
    }

    public function getOrderById($id)
    {
        $order = Order::with(['OrderDetails.ProductVariation.Product','OrderDetails.ProductVariation.ProductColor','OrderDetails.ProductVariation.ProductSize','StatusOrder','OrderDetails.ProductVariation.Feedback'])->find($id);
        $totalOriginPrice = 0;
        foreach ($order->OrderDetails as $item) {
            $totalOriginPrice += ($item->Price * $item->Quantity);
        }

        return response()->json([
            'order'=> $order,
            'totalOriginPrice'=>$totalOriginPrice
        ]);
    }

    public function changeStatus($id)
    {
     
        $order = Order::with('OrderDetails.ProductVariation.Product')->find($id);
        $order->StatusOrderId = $order->StatusOrderId +1;
        $order->save();

        if($order->StatusOrderId == 2){
            $message = "Đang vận chuyển";
        }
        else{
            $message = "Thành công";
            // Cập nhật thông tin thống kê
            $Date = Carbon::now();

            $statistical = Statistical::whereDate('Date', $Date)->first();
            
            
            if ($statistical!=null) {
                $statistical->Revenue += $order->MoneyTotal;
                $statistical->Quantity += $order->OrderDetails->sum('Quantity');

                foreach ($order->OrderDetails as $detail) {
                    $profit = $detail->DiscountPrice > 0 ?
                        ($detail->DiscountPrice - $detail->ProductVariation->Product->ImportPrice) * $detail->Quantity :
                        ($detail->Price - $detail->ProductVariation->Product->ImportPrice) * $detail->Quantity;
                    $statistical->Profit += $profit;
                    
                    $pv = ProductVariation::find($detail->ProVariationID);
                    $pv->Ordered = $pv->Ordered - $detail->Quantity;
                    $pv->Quantity = $pv->Quantity - $detail->Quantity;
                    $pv->save();

                }

                $statistical->Total_Order += 1;
                $statistical->save();
            } else {
                $statisticalNew = new Statistical();
                $statisticalNew->Revenue = $order->MoneyTotal;
                $statisticalNew->Date = $Date;
                $statisticalNew->Quantity = $order->orderDetails->sum('Quantity');
                
                foreach ($order->orderDetails as $detail) {
                    $profit = $detail->DiscountPrice > 0 ?
                        ($detail->DiscountPrice - $detail->ProductVariation->Product->ImportPrice) * $detail->Quantity :
                        ($detail->Price - $detail->ProductVariation->Product->ImportPrice) * $detail->Quantity;
                    $statisticalNew->Profit += $profit;
                }

                $statisticalNew->Total_Order = 1;
                $statisticalNew->save();
            }

            foreach($order->OrderDetails as $detail){
                //lưu xuống report product
                $reportproduct = ReportProduct::whereDate('Date', $Date)->where('ProId',$detail->ProductVariation->ProId)
                ->where('ProColorID',$detail->ProductVariation->ProColorID)->first();
                if($reportproduct!=null){
                    if($detail->DiscountPrice>0){
                        $reportproduct->Revenue +=$detail->DiscountPrice * $detail->Quantity;                       
                        $reportproduct->Profit += ($detail->DiscountPrice - $detail->ProductVariation->Product->ImportPrice) * $detail->Quantity;
                        $reportproduct->Quantity += $detail->Quantity;
                    }
                    else{
                        $reportproduct->Revenue +=$detail->Price * $detail->Quantity;
                        $reportproduct->Profit += ($detail->Price - $detail->ProductVariation->Product->ImportPrice) * $detail->Quantity;;
                        $reportproduct->Quantity += $detail->Quantity;
                    }
                    $reportproduct->save();
                }
                else{
                    $reportproductNew = new ReportProduct();
                    $reportproductNew->Quantity = $detail->Quantity;
                    $reportproductNew->Date = $Date;
                    $reportproductNew->ProId = $detail->ProductVariation->ProId;
                    $reportproductNew->ProColorID = $detail->ProductVariation->ProColorID;
                    if($detail->DiscountPrice>0){
                        
                        $reportproductNew->Revenue = $detail->DiscountPrice * $detail->Quantity;
                        $reportproductNew->Profit = ($detail->DiscountPrice - $detail->ProductVariation->Product->ImportPrice) * $detail->Quantity;
                    }
                    else{

                        $reportproductNew->Revenue =$detail->Price * $detail->Quantity;
                        $reportproductNew->Profit = ($detail->Price - $detail->ProductVariation->Product->ImportPrice) * $detail->Quantity;;
                    }

                    $reportproductNew->save();
                }
            }
            

        }

        return response()->json($message);
    }

    public function cancelOrder($id)
    {
        try {
            $order = Order::find($id);
            foreach($order->OrderDetails as $detail){
                $pv = ProductVariation::find($detail->ProVariationID);
                $pv->Ordered = $pv->Ordered - $detail->Quantity;
                $pv->save();
            }
            $order->delete();
            return response()->json(true);
        } catch (\Exception $ex) {
            return response()->json(false);
        }
    }
}
