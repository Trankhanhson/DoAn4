<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductSize;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductSizeController extends Controller
{
    public function getAll(){
        $listSize = ProductSize::all();
        return response()->json([
            'listSize'=>$listSize
        ]);
    }
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $proSize = new ProductSize;
        $proSize->NameSize = $request->NameSize;
        $proSize->save();
        return response()->json([
            'check' => true,
            'proSize' => $proSize
        ]);
        try{

        }
        catch(Exception $e){
            return response()->json([
                'check' => false
            ]);
        }
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
            $proSize = ProductSize::findOrFail($id);
            $proSize->NameSize = $request->NameSize;
            $proSize->save();
            return true;
        }
        catch(Exception $e){
            return false;
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
        $message = "";
        $check = true;
        try{
            $proSize = ProductSize::findOrFail($id);
            $proSize->delete();
            $message="Xóa thành công";
        }
        catch(Exception $e){
            $check = false;
            $message = "xóa thất bại";
        }

        return response()->json([
            'message'=>$message,
            'check' =>$check
        ]);
    }
}
