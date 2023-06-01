<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\DiscountDetail;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Nette\Utils\Json;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;

class CartController extends Controller
{
    public function getNewCart(Request $request){
        $currentDateTime = Carbon::now();
        $discountDetails = DiscountDetail::join('discountproduct', 'discountdetail.DiscountProductId', '=', 'discountproduct.DiscountProductId')
        ->where('discountproduct.StartDate', '<=', $currentDateTime)
        ->where('discountproduct.EndDate', '>=', $currentDateTime)
        ->orderByDesc('discountproduct.DiscountProductId')
        ->get();

        $variationCarts = json_decode($request->variationCarts);
        $newVariationCarts = new Collection();
        if($variationCarts){
            foreach($variationCarts as $item){
                //check exist of product
                $product = Product::with(['ProductImages', 'ProductVariations' => function ($query) {
                    $query->where('Status', 1);
                }])->where('ProId',$item->ProId)
                ->where('Status',1)->first();

                if($product){
                    $pv = $product->ProductVariations->where('ProColorID',$item->proColorId)
                    ->where('ProSizeID',$item->proSizeId)
                    ->where('Status',1)->first();
                    $item->DiscountPrice = 0;
                    $item->Percent = 0;
                    if($pv && ( $pv->Quantity - $pv->Ordered) >= $item->Quantity){
                        foreach ($discountDetails as $dt) {
                            if ($dt->ProId == $product->ProId) {
                                if ($dt->TypeAmount == "0") { // giảm giá theo tiền
                                    $item->DiscountPrice = $product->Price - $dt->Amount;
                                    $item->Percent = ($dt->Amount*100 / $product->Price);
                                } else { // giảm giá theo %
                                    $item->Percent = $dt->Amount;
                                    $item->DiscountPrice = round($product->Price - (($dt->Amount / 100) * $product->Price), 0);
                                }
                                break;
                            }
                        }
                        $item->Price = $product->Price;
                        $item->ProName = $product->ProName;
                        $item->Image = "/storage/uploads/Product/".$product->ProductImages->where('ProColorID',$item->proColorId)->first()->Image;
                        $item->ProName = $product->ProName;
                        $newVariationCarts->push($item);
                    }
                }
            }
        }

        return response()->json($newVariationCarts->toJson());
    }

    public function CartView(){
        return view('client.cart');
    }

    public function checkQuantity(Request $request)
    {
        $data = json_decode($request->data);
        $ProId = $data->ProId;
        $ProColorId = $data->ProColorId;
        $ProSizeId = $data->ProSizeId;
        $newQuantity = $data->newQuantity;
        $productVariation = ProductVariation::where('ProId',$ProId)->where('ProSizeID',$ProSizeId)->where('ProColorID',$ProColorId)->first();

        if (($productVariation->Quantity - $productVariation->Ordered) >= $newQuantity) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    public function paymentPage(Request $request)
    {
        $customer = null;
        $vouchers = [];
    
        if ($request->hasCookie('CustomerId')) {
            $id = $request->cookie('CustomerId');
            $customer = Customer::find($id);
        }
    
        return view('client.payment-page')->with([
            'Customer' => $customer,
        ]);
    }


    public function infoBill($id)
    {
        $order = Order::with('OrderDetails.ProductVariation.Product','OrderDetails.ProductVariation.ProductColor','OrderDetails.ProductVariation.ProductSize','StatusOrder')->find($id);
        $totalOriginPrice = 0;

        foreach ($order->OrderDetails as $item) {
            $totalOriginPrice += ($item->Price * $item->Quantity);
        }
    
        $totalDiscount = $totalOriginPrice - $order->MoneyTotal;
    
        return view('client.InfoBill', ['order'=>$order,'totalOriginPrice'=>$totalOriginPrice,'totalDiscount'=>$totalDiscount]);
    }

    public function order(Request $request)
    {
        $orderIn = json_decode($request->order);
        /**lưu order */
        $order = new Order();
        if($orderIn->CusID !=0){
            $order->CusID = $orderIn->CusID;
        }
        $order->ReceivingName = $orderIn->ReceivingName;
        $order->ReceivingPhone = $orderIn->ReceivingPhone;
        $order->ReceivingCity = $orderIn->ReceivingCity;
        $order->ReceivingDistrict = $orderIn->ReceivingDistrict;
        $order->ReceivingWard = $orderIn->ReceivingWard;
        $order->ReceivingAddress = $orderIn->ReceivingAddress;
        $order->PaymentType = $orderIn->PaymentType;
        $order->MoneyTotal = $orderIn->MoneyTotal;
        $order->Note = $orderIn->Note;
        $order->OrderDate = Carbon::now();
        $order->save();
        $cartItems = json_decode($request->cartItems);
        foreach ($cartItems as $item) {
            $pv = ProductVariation::where('ProSizeID',$item->ProSizeId)->where('ProColorID',$item->ProColorId)->where('ProId',$item->ProId)->first();
            $pv->Ordered +=$item->Quantity;
            $pv->save();
            $orderDetail = new OrderDetail();
            $orderDetail->OrdID = $order->OrdID;
            $orderDetail->ProVariationID = $pv->ProVariationID;
            $orderDetail->Price = $item->Price;
            $orderDetail->Quantity = $item->Quantity;
            $orderDetail->DiscountPrice = $item->DiscountPrice;
            $orderDetail->save();
        }
        return response()->json($order['OrdID']);
    }

}
