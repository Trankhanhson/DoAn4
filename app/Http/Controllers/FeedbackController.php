<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Exception;

class FeedbackController extends Controller
{
    // function __construct()
    // {
    //      $this->middleware('permission:Quản lý feedback');
    // }
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.feedback');
    }

    public function getPageData(Request $request){
        $searchText = $request->input('searchText', '');
        $pageNumber = $request->input('pageNumber', 1);
        $pageSize = $request->input('pageSize', 5);
        $StatusFeedback = json_decode($request->input('StatusFeedback'));
        if ($searchText)
        {
            $feedbacks = Feedback::with(['Customer','ProductVariation.Product'])->whereHas('ProductVariation.Product', function ($query) use ($searchText) {
                $query->where('ProName','like', '%' . $searchText . '%');
            })->where("Status",$StatusFeedback)->get();
        }
        else{
            $feedbacks = Feedback::with(['Customer','ProductVariation.Product'])->where("Status",$StatusFeedback)->get();
        }

        $Data = array_slice($feedbacks->toArray(), ($pageNumber - 1) * $pageSize, $pageSize);
        $TotalCount = count($feedbacks);
        return response()->json([
            'Data' => $Data,
            'TotalCount' =>$TotalCount,
        ]); 
     }

    public function getById($id){
        $feedback = Feedback::with(['Customer','ProductVariation.Product'])->find($id);
        
        return response()->json($feedback);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $feedback = new Feedback();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::random(40) . '.' . $extension;
            $file->storeAs('public/uploads/Feedback', $fileName);
            $feedback->Image = $fileName;
        }
        $feedback->CusID = $request->CusID;
        $feedback->ProVariationID = $request->ProVariationID;
        $feedback->Stars = $request->Stars;
        $feedback->Content = $request->Content;
        $feedback->Datetime = Carbon::now();
        $feedback->Status = 0;
        $feedback->save();
        $feedback->load('Customer');
        return response()->json([
            'check' => true,
            'idFeedback' => $feedback->FeedbackId
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
     * @param  \App\Models\ProductCat  $ProductCat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            $feedback = Feedback::find($id);
            if ($request->hasFile('file')) {
                //delete old file if user upload new file
                $oldPath = storage_path('app/public/uploads/Feedback/'.$feedback->Image);
                if(File::exists($oldPath)){
                    File::delete($oldPath);
                }
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $fileName = Str::random(40) . '.' . $extension;
                $file->storeAs('public/uploads/Feedback', $fileName);
                $feedback->Image = $fileName;
            }
            $feedback->Stars = $request->Stars;
            $feedback->Content = $request->Content;
            $feedback->Status = 0;
            $feedback->save();
        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCat  $ProductCat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = "";
        $check = true;
        try{
            $procat = Feedback::findOrFail($id);
            $path = storage_path('app/public/uploads/ProductCat/'.$procat->Image);
            if (File::exists($path)) {
                // Nếu ảnh cũ chưa tồn tại, xóa ảnh cũ để thêm ảnh mới
                File::delete($path);
            }
            $procat->delete();
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
        $feedback = Feedback::findOrFail($id);
        $feedback->Status = !$feedback->Status;
        $feedback->save();
    }

    public function getByProduct(Request $request)
    {
        $proId = $request->input('proId');
        $star = $request->input('star');
        $image = $request->input('Image');

        $feedbacks = Feedback::with(['ProductVariation.Product','ProductVariation.ProductColor','ProductVariation.ProductSize','Customer'])->where('Status', 1)->whereHas('ProductVariation.Product', function ($query) use ($proId) {
            $query->where('ProId',$proId);
        })->get();

        if ($star != 0 && $image !== null) {
            $feedbacks = $feedbacks->where('Stars', $star)->where('Image','!=',"");
        } elseif ($star != 0 && $image === null) {
            $feedbacks = $feedbacks->where('Stars', $star);
        } elseif ($image !== null && $star == 0) {
            $feedbacks = $feedbacks->where('Image','!=',"");
        }

        return response()->json($feedbacks);
    }

    public function getTotalReview($id)
    {
        $feedbacks = Feedback::with(['ProductVariation.Product','Customer'])->where('Status', 1)->whereHas('ProductVariation.Product', function ($query) use ($id) {
            $query->where('ProId',$id);
        })->get();
        if ($feedbacks !== null) {
            $totalRating = 0;
            foreach ($feedbacks as $item) {
                $totalRating += $item->Stars;
            }
            $length = count($feedbacks);
            $ratingAverage = 0;
            if ($totalRating > 0) {
                $ratingAverage = $totalRating / $length;
            }
            return response()->json([
                'check' => true,
                'totalReview' => $length,
                'ratingAverage' => $ratingAverage
            ]);
        } else {
            return response()->json([
                'check' => false
            ]);
        }
    }
}
