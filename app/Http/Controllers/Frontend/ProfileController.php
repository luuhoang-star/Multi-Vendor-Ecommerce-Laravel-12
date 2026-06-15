<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AlertService;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View; // import giao diện view
use Illuminate\Http\RedirectResponse; //dùng làm kiểu dữ liệu trả về (return type)
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use FileUploadTrait;
    // View trả về view
    function index(): View
    {
        return view('frontend.dashboard.account.index');
    }

    function profileUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:users,email,' . auth('web')->user()->id],
            'avatar' => ['nullable', 'image', 'max:2048'], // avt có thể rộng
        ]);

        $user = auth('web')->user();
        if ($request->hasFile('avatar')) {
            $filepath = $this->uploadFile($request->file('avatar'), $user->avatar); // trả về đường dẫn ảnh mới
            $filepath ? $user->avatar = $filepath : null;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        AlertService::updated();

        return redirect()->back();
    }

    function passwordUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = auth('web')->user();
        $user->password = bcrypt($request->password);
        $user->save();

        AlertService::updated();

        return redirect()->back();
    }
}
