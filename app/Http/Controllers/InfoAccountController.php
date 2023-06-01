<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Exception;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariation;

class InfoAccountController extends Controller
{
    public function infoCustomer(Request $request)
    {
        $customer = new Customer();
        if ($request->cookie('CustomerId')) {
            $id = (int)$request->cookie('CustomerId');
            $customer = Customer::find($id);
            return view('client.InfoCustomer.InfoAccount', compact('customer'));
        } else {
            return redirect()->route('client.index');
        }
    }

    public function updateInfoCustomer(Request $request)
    {
        $customerId = $request->input('CusID');
        $phone = $request->input('Phone');
        $Name = $request->input('Name');
        $Address = $request->input('Address');
        $customer = Customer::find($customerId);
        $message = '';

        try {
            if ($phone !== $customer->Phone && Customer::where('Phone', $phone)->exists()) {
                $message = 'ExistPhone';
            } else {
                $customer->Phone = $phone;
                $customer->Name = $Name;
                $customer->Address = $Address;
                $customer->save();
                $message = 'success';
            }
        } catch (Exception $e) {
            $message = 'fail';
        }

        return response()->json([
            'message' => $message
        ]);
    }

    public function orderHistory(Request $request)
    {
        if ($request->cookie('CustomerId')) {
            $id = (int)$request->cookie('CustomerId');
            $customer = Customer::find($id);
            return view('client.InfoCustomer.OrderHistory', compact('customer'));
        } else {
            return redirect()->route('client.index');
        }
    }

    public function getOrderByCusId(Request $request)
    {
        $id = $request->input('id');
        $statusId = $request->input('statusId');

        if($statusId == 0){
            $orders = Order::where('CusID', $id)
            ->with('StatusOrder')
            ->get()
            ->map(function ($o) {
                return [
                    'OrdID' => $o->OrdID,
                    'MoneyTotal' => $o->MoneyTotal,
                    'OrderDate' => $o->OrderDate,
                    'StatusOrderId'=> $o->StatusOrderId,
                    'StatusOrder' => [
                        'StatusOderId' => $o->statusOrder->StatusOderId,
                        'Status' => $o->statusOrder->Status
                    ]
                ];
            });
        }
        else{
            $orders = Order::where('CusID', $id)
            ->where('StatusOrderId', $statusId)
            ->with('StatusOrder')
            ->get()
            ->map(function ($o) {
                return [
                    'OrdID' => $o->OrdID,
                    'MoneyTotal' => $o->MoneyTotal,
                    'OrderDate' => $o->OrderDate,
                    'StatusOrder' => [
                        'StatusOderId' => $o->statusOrder->StatusOderId,
                        'Status' => $o->statusOrder->Status
                    ]
                ];
            });
        }

        return response()->json([
            'result' => $orders
        ]);
    }
    public function cancelOrder($id)
    {
        try {
            
            $order = Order::find($id);
            $order->StatusOrderId = 4;
            $order->save();
            foreach($order->OrderDetails as $item){
                $pv = ProductVariation::find($item->ProVariationID);
                $pv->Ordered -= $item->Quantity;
                $pv->save();
            }
            return response()->json(true);
        } catch (Exception $e) {
            return response()->json(false);
        }
    }
}
