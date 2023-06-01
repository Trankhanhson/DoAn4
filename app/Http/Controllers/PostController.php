<?php

namespace App\Http\Controllers;

use App\Models\post;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    // function __construct()
    // {
    //      $this->middleware('permission:Quản lý bài viết');
    // }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.post.Post');
    }

    public function getPageData(Request $request){
        $searchText = $request->input('searchText', '');
        $pageNumber = $request->input('pageNumber', 1);
        $pageSize = $request->input('pageSize', 5);
        $query = Post::with('User');
        if ($searchText)
        {
            $query = $query->where('Title', 'LIKE', '%' . $searchText . '%');
        }

        $Data = $query->skip(($pageNumber - 1) * $pageSize)->take($pageSize)->get();
        $TotalCount = $query->count();
        
        return response()->json([
            'Data' => $Data,
            'TotalCount' =>$TotalCount
        ]); 
     }

    public function getById($id){
        $post = Post::with('User')->where('PostId',$id)->first();
        return response()->json($post);
    }

    public function createView(){
        $listUser = User::all(['id','name']);
        return view('admin.post.Create',['listUser'=>$listUser]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $post = new Post();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $file->storeAs('public/uploads/Post', $fileName);
            $post->Image = $fileName;
        }
        $post->UserID = $request->UserID;
        $post->Title = $request->Title;
        $post->Content = $request->Content;
        $post->save();
        return response()->json([
            'check' => true,
            'post' => $post
        ]);
        try{

        }
        catch(Exception $e){
            return response()->json([
                'check' => false
            ]);
        }
    }
    public function updateView($id){
        $listUser = User::all(['id','name']);
        $post = Post::find($id);
        return view('admin.post.Update',['listUser'=>$listUser,'post'=>$post]);
    }
        /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if ($request->hasFile('file')) {
            //delete old file if user upload new file
            $oldPath = storage_path('app/public/uploads/Post/'.$post->Image);
            if(File::exists($oldPath)){
                File::delete($oldPath);
            }
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $file->storeAs('public/uploads/Post', $fileName);
            $post->Image = $fileName;
        }
        $post->UserID = $request->UserID;
        $post->Title = $request->Title;
        $post->Content = $request->Content;
        $post->save();
        return response()->json([
            'check' => true,
            'post' => $post
        ]);
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
            $post = Post::findOrFail($id);
            $path = storage_path('app/public/uploads/Post/'.$post->Image);
            if (File::exists($path)) {
                // Nếu ảnh cũ chưa tồn tại, xóa ảnh cũ để thêm ảnh mới
                File::delete($path);
            }
            $post->delete();
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
