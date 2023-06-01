<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\post;

class PostClientController extends Controller
{

    public function index()
{
    $recentPosts = post::take(10)->get();
    return view('client.news-home', compact('recentPosts'));
}

public function getPageData(Request $request)
{
    $searchText = $request->input('searchText');
    $pageNumber = $request->input('pageNumber', 1);
    $pageSize = $request->input('pageSize', 5);

    $news = post::select('PostId', 'Title', 'UserID', 'Image', 'PublicDate')->get();

    if (!empty(trim($searchText))) {
        $news = $news->filter(function ($new) use ($searchText) {
            return stripos($new->Title, $searchText) !== false;
        });
    }

    $Data = array_slice($news->toArray(), ($pageNumber - 1) * $pageSize, $pageSize);
    $TotalCount = count($news);
    return response()->json([
        'Data' => $Data,
        'TotalCount' =>$TotalCount
    ]); 
}

public function detailPost($id)
{
    $post = post::find($id);
    return view('client.news-detail', compact('post'));
}
}
