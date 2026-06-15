<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckKycStatus
{
    /**
     * Chỉ cho phép Vendor đã được KYC Approved truy cập.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Lấy user đang đăng nhập
        $user = auth('web')->user();

        // Chưa gửi KYC, đang chờ duyệt hoặc bị từ chối
        // => Không cho truy cập route được bảo vệ
        if (
            $user->kyc?->status == 'pending' ||
            $user->kyc?->status == 'rejected' ||
            $user->kyc?->status == null
        ) {
            return redirect()->route('vendor.dashboard');
        }

        // KYC đã được duyệt
        // => Cho request đi tiếp tới Controller
        elseif ($user->kyc?->status == 'approved') {
            return $next($request);
        }

        // Trạng thái không hợp lệ
        return abort(403);
    }
}
