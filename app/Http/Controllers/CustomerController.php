<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // function __construct()
    // {
    //      $this->middleware('permission:Quản lý khách hàng');
    // }
    public function index(){
        return view('admin.Customer');
    }

    public function getPageData(Request $request){
        $searchText = $request->input('searchText', '');
        $pageNumber = $request->input('pageNumber', 1);
        $pageSize = $request->input('pageSize', 5);
        if ($searchText)
        {
            $productCats = Customer::where('Name', 'LIKE', '%' . $searchText . '%')->orWhere('Phone', 'LIKE', '%' . $searchText . '%')->get();
        }
        else{
            $productCats = Customer::all();
        }

        $Data = array_slice($productCats->toArray(), ($pageNumber - 1) * $pageSize, $pageSize);
        $TotalCount = count($productCats);
        return response()->json([
            'Data' => $Data,
            'TotalCount' =>$TotalCount
        ]); 
     }

     public function changeStatus($id){
        $c = Customer::find($id);
        $c->Status = !$c->Status;
        $c->save();
     }
}
