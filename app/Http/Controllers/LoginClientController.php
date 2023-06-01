<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class LoginClientController extends Controller
{
    public function register(Request $request)
    {
        $message = "";

        if (Customer::where('Phone', $request->Phone)->exists()) {
            $message = "ExistPhone";
        } else {
            $customer = new Customer();
            $customer->Phone = $request->Phone;
            $customer->Password =$request->Password;
            $customer->Name =$request->Name;
            $customer->Address = $request->Address;
            $customer->status = true;

            if ($customer->save()) {
                $message = "success";
            } else {
                $message = "fail";
            }
        }

        return response()->json([
            'message' => $message
        ]);
    }

    public function login(Request $request)
    {
        $customer = Customer::where('Phone', $request->Phone)->where('Password',$request->Password)->first();

        if ($customer!=null) {
            
            $id = $customer->CusID;
            // Set a cookie with id and username
            $cookie = cookie('CustomerId', $id, 525600); // Expires in 1 year
            return response()->json([
                'check' => true
            ])->cookie($cookie);
        }
        return response()->json([
            'check' => false
        ]);
    }

    public function logout()
    {
        $cookie = Cookie::forget('CustomerId');
        return redirect()->route('client.index')->withCookie($cookie);
    }

    public function ConfirmPhone($id){
        $check = Customer::where('Phone',$id)->first();
        if($check!=null){
            return response()->json([
                'check' => true
            ]);
        }
        else{
            return response()->json([
                'check' => false
            ]); 
        }
    }
}
