<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Services\AlertService; // sử dụng use này để tạo thông báo tự động
use App\Services\MailService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KycRequestController extends Controller

{

    static function Middleware(): array
    {
        return [
            new Middleware('permission:KYC Management')
        ];
    }
    function index(): View
    {

        $kycRequests = Kyc::paginate(25);
        return view('admin.kyc.index', compact('kycRequests'));
    }
    public function pending(): View
    {
        $kycRequests = Kyc::where('status', 'pending')
            ->paginate(25);

        return view('admin.kyc.index', compact('kycRequests'));
    }


    public function rejected(): View
    {
        $kycRequests = Kyc::where('status', 'rejected')
            ->paginate(25);

        return view('admin.kyc.index', compact('kycRequests'));
    }

    function show(Kyc $kyc_request): View
    {
        return view('admin.kyc.show', compact('kyc_request'));
    }

    function download(Kyc $kyc_request): StreamedResponse
    {
        return Storage::disk('local')->download($kyc_request->document_scan_copy);
    }
    function update(Kyc $kyc_request, Request $request): RedirectResponse
    {
        $kyc_request->update([
            'status' => $request->status // cập nhật trạng thái
        ]);
        if ($kyc_request->status == 'approved') {
            MailService::send(
                to: $kyc_request->user->email,
                subject: 'Hồ sơ xác minh KYC đã được duyệt',
                body: 'Chúc mừng! Hồ sơ KYC của bạn đã được phê duyệt.'
            );
        } elseif ($kyc_request->status == 'rejected') {
            MailService::send(
                to: $kyc_request->user->email,
                subject: 'Hồ sơ xác minh KYC đã bị từ chối',
                body: 'Xin lỗi! Hồ sơ KYC của bạn đã bị từ chối.'
            );
        }

        AlertService::updated();

        return redirect()->route('admin.kyc.index'); // chuyển hướng về trang admin quản lý
    }
}
