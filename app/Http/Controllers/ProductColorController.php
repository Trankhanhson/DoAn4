<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\ProductColor;

class ProductColorController extends Controller
{

    public function getAll(){
        $listColor = ProductColor::all();
        return response()->json([
            'listColor'=>$listColor
        ]);
    }
    public function create(Request $request)
    {
        try{
            $proColor = new ProductColor;
            // Gán các giá trị từ request vào các trường tương ứng
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $fileName = Str::random(40) . '.' . $extension;
                $file->storeAs('public/uploads/ProductColor', $fileName);
                $proColor->ImageColor = $fileName;
            }
            $proColor->NameColor = $request->NameColor;
            $proColor->save();
            return response()->json([
                'check' => true,
                'proColor' => $proColor
            ]);
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
            $proColor = ProductColor::findOrFail($id);
            if ($request->hasFile('file')) {
                //delete old file if user upload new file
                $oldPath = storage_path('app/public/uploads/ProductColor/'.$proColor->ImageColor);
                if(File::exists($oldPath)){
                    File::delete($oldPath);
                }
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $fileName = Str::random(40) . '.' . $extension;
                $file->storeAs('public/uploads/ProductColor', $fileName);
                $proColor->ImageColor = $fileName;
            }
            $proColor->NameColor = $request->NameColor;
            $proColor->save();
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
            $proColor = ProductColor::findOrFail($id);
            $proColor->delete();
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
