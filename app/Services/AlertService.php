<?php

namespace App\Services; // Cho Laravel biết class này nằm trong thư mục

class AlertService {
    public static function updated($message = null) { // static nghĩa là: có thể gọi trực tiếp mà ko cần tạo object.
           notyf()->success($message ? $message: 'Updated Successfully.');
    }
      public static function created($message = null) { // static nghĩa là: có thể gọi trực tiếp mà ko cần tạo object.
           notyf()->success($message ? $message: 'Created Successfully.');
    }
}
