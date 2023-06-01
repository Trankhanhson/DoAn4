<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AccessLog;

class TrackAccess
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('/')) { // Chỉ lưu trữ khi là yêu cầu trang chính
            $accessLog = new AccessLog();
            $accessLog->ip_address = $request->ip();
            $accessLog->user_agent = $request->header('User-Agent');
            $accessLog->user_id = auth()->id(); // Nếu có đăng nhập, nếu không thì để null
            $accessLog->save();
        }

        return $next($request);
    }
}
