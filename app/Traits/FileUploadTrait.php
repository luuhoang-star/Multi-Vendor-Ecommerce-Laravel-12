<?php


namespace App\Traits;

use Illuminate\Support\Facades\File; // Làm việc vs file/folder
use Illuminate\Http\UploadedFile; // Kiểu dữ liệu file upload
use Illuminate\Support\Str; // Tạo chuỗi ngẫu nhiên (uuid)

trait FileUploadTrait
{
    public function uploadFile(UploadedFile $file, ?string $oldPath = null, ?string $path = 'uploads'): ?string
    {
        if (!$file->isValid()) {
            return null;
        }

        $ignorePath = ['/default/avatar.png', 'defaults/banner.png', '/defaults/shop.png']; // danh sách file k đc xóa

        if ($oldPath && File::exists(public_path($oldPath)) && !in_array($oldPath, $ignorePath)) {
            File::delete(public_path($oldPath)); // Xóa file cũ đi
        }

        $folderPath = public_path($path); // Xác định thư mục lưu file public/upload/abc.png

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension(); // Tạo tên file ngẫu nhiên

        $file->move($folderPath, $filename); // di chuyển file vào thư mục uploads
        $filepath = $path . '/' . $filename; // trả về đường đẫn ms uploads/...

        return $filepath;
    }

    public function uploadPrivateFile(UploadedFile $file, ?string $oldPath = null, ?string $path = 'uploads'): ?string
    {
        if (!$file->isValid()) {
            return null;
        }

        // $ignorePath = ['/default/avatar.png'];

        // if($oldPath && File::exists(public_path($oldPath)) && !in_array($oldPath, $ignorePath)) {
        //     File::delete(public_path($oldPath)); // Xóa file cũ đi
        // }
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($path, $filename, 'local');

        return $path;
    }
}
