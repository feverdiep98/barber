<?php
namespace App\Helpers;

class TrackingNumberGenerator
{
    public static function generate()
    {
        // Logic để tạo mã số tracking number
        // Ví dụ: trả về một chuỗi ngẫu nhiên
        return 'ABC' . uniqid();
    }
}
