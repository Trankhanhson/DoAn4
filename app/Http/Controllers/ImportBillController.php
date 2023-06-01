<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportBill;
use App\Models\ImportBillDetail;
use App\Models\Product;
use App\Models\User;
use Exception;
use Nette\Utils\Json;
use Carbon\Carbon;
use App\Models\ProductVariation;

class ImportBillController extends Controller
{
    // function __construct()
    // {
    //      $this->middleware('permission:Quản lý hóa đơn nhập');
    // }
    public function index()
    {
        return view('admin.importbill.ImportBill');
    }

    public function getPageData(Request $request){
        $searchText = $request->input('searchText', '');
        $pageNumber = $request->input('pageNumber', 1);
        $pageSize = $request->input('pageSize', 5);
        // if ($searchText)
        // {
        //     $productCats = ImportBill::where('Name', 'LIKE', '%' . $searchText . '%')->orWhere('Phone', 'LIKE', '%' . $searchText . '%')->get();
        // }
        // else{
            $productCats = ImportBill::with('User')->orderByDesc('created_at')->get();
        // }

        $Data = array_slice($productCats->toArray(), ($pageNumber - 1) * $pageSize, $pageSize);
        $TotalCount = count($productCats);
        return response()->json([
            'Data' => $Data,
            'TotalCount' =>$TotalCount
        ]); 
    }


    /**Sử dụng để hiển thị lên khi sửa */
    public function getById($id){
        $dao = ImportBill::with(['ImportBillDetails.ProductVariation.ProductColor','ImportBillDetails.ProductVariation.ProductSize','ImportBillDetails.ProductVariation.Product','User'])->where('ImpId',$id)->first();
        return response()->json($dao);
    }

    
    public function createView(){
        $listUser = User::all();
        return view('admin.importbill.Create',['listUser'=>$listUser]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {            
        //take data
        $importBillIn = json_decode($request->ImportBill);
        $billDetails = json_decode($request->billDetails);
        $listProduct = json_decode($request->listProduct);
        //save importbill
        $importBill = new ImportBill();
        $importBill->StaffId = $importBillIn->StaffId;
        $importBill->MoneyTotal = $importBillIn->MoneyTotal;
        $importBill->save();
        //save list of inportbilldetail and edit quantity in provariation
        foreach($billDetails as $detail){ 
            $a = new ImportBillDetail();
            $a->ProVariationID = $detail->ProVariationID;
            $a->ImpId = $importBill->ImpId;
            $a->Quantity = $detail->Quantity;
            $a->ImportPrice = $detail->ImportPrice;
            $a->save();

            //edit quantity
            $v = ProductVariation::find($detail->ProVariationID);
            $v->Quantity += $detail->Quantity;
            $v->save();
        }

        //edit importprice and exportprice in product
        foreach($listProduct as $p){
            $product = Product::find($p->ProId);
            $product->Price = $p->Price;
            $product->ImportPrice = $p->ImportPrice;
            $product->save();
        }
        try{


            return response()->json(true);
        }
        catch(Exception $e){
            return response()->json(false);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
