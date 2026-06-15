<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Services\AlertService;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KycController extends Controller
{
    use FileUploadTrait;

    function index(): View | RedirectResponse
    {
        if (auth('web')->user()->kyc?->status == 'approved' || auth('web')->user()->kyc?->status == 'pending') {
            return redirect()->route('vendor.dashboard');
        }
        return view('frontend.pages.kyc');
    }
    function store(Request $request): RedirectResponse
    {
        // Bước 1: Validate dữ liệu người dùng gửi lên
        $request->validate([
            'full_name'          => ['required', 'max:255', 'string'],
            'date_of_birth'      => ['required', 'date'],
            'gender'             => ['required', 'max:255', 'string'],
            'full_address'       => ['required', 'max:255', 'string'],
            'document_type'      => ['required', 'max:255', 'string'],
            'document_scan_copy' => ['required', 'mimes:png,pdf,csv,docx', 'max:10000']
        ]);

        // Bước 2: Kiểm tra user đã có KYC chưa
        if (Kyc::where('user_id', auth('web')->user()->id)->exists()) {

            // Đã có KYC => lấy bản ghi cũ để cập nhật
            $kyc = Kyc::where('user_id', auth('web')->user()->id)->first();
        } else {

            // Chưa có KYC => tạo mới
            $kyc = new Kyc();
        }

        // Bước 3: Gán dữ liệu từ form vào model KYC
        $kyc->full_name      = $request->full_name;
        $kyc->status         = 'pending'; // luôn chuyển về pending khi gửi lại
        $kyc->user_id        = auth('web')->user()->id;
        $kyc->date_of_birth  = $request->date_of_birth;
        $kyc->gender         = $request->gender;
        $kyc->full_address   = $request->full_address;
        $kyc->document_type  = $request->document_type;

        // Bước 4: Upload file giấy tờ lên storage
        $filePath = $this->uploadPrivateFile(
            $request->file('document_scan_copy')
        );

        // Lưu đường dẫn file vào database
        $kyc->document_scan_copy = $filePath;

        // Bước 5: Lưu dữ liệu vào database
        $kyc->save();

        // Bước 6: Hiển thị thông báo thành công
        AlertService::created(
            'Kyc của bạn đã gửi thành công! Vui lòng đợi sự đồng ý của quản trị viên.'
        );

        // Bước 7: Chuyển về dashboard vendor
        return redirect()->route('vendor.dashboard');
    }
}
