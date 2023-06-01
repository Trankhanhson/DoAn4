<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Exception;
use App\Models\PagedData;

class CategoryController extends AdminController
{
    // function __construct()
    // {
    //      $this->middleware('permission:Danh sách danh mục|Thêm danh mục|Sửa danh mục|Xóa danh mục');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listType = ["Nam","Nữ","Bé trai","Bé gái"];
        return view('admin.Category',['listType'=>$listType]);
    }

    public function getPageData(Request $request){
        $searchText = $request->input('searchText', '');
        $pageNumber = $request->input('pageNumber', 1);
        $pageSize = $request->input('pageSize', 5);
        if ($searchText)
        {
            $categories = Category::where('Name', 'LIKE', '%' . $searchText . '%')->get();
        }
        else{
            $categories = Category::all();
        }

        $Data = array_slice($categories->toArray(), ($pageNumber - 1) * $pageSize, $pageSize);
        $TotalCount = count($categories);
        
        return response()->json([
            'Data' => $Data,
            'TotalCount' =>$TotalCount
        ]); 
     }


     public function getByType($id){
        $categories = Category::with('ProductCats')->where('type',$id)->get();

        return response()->json($categories);
     }

    public function getById($id){
        $cat = Category::find($id);
        return response()->json($cat);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try{
            $cat = new Category;
            // Gán các giá trị từ request vào các trường tương ứng
            $cat->Name = $request->input('Name');
            $cat->type = $request->input('type');
            $cat->Active = $request->input('Active');
            $cat->save();
            return response()->json([
                'message' => true,
                'cat' => $cat
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'message' => false
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
            $cat = Category::findOrFail($id);
            $cat->Name = $request->input('Name');
            $cat->type = $request->input('type');
            $cat->save();
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
            $cat = Category::findOrFail($id);
            $cat->delete();
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

    public function changeStatus($id){
        $cat = Category::findOrFail($id);
        $cat->Active = !$cat->Active;
        $cat->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }


}
