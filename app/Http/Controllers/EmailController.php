<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(){
        $to_name = "phat";
        $to_email = "007phatdiep@gmail.com";

        $data = array("name"=> "Mail từ tài khoản khách hàng","body"=>"Xác Nhận Đơn Hàng");

        // Kiểm tra xem cấu hình email có tồn tại không
        if (config('mail.mailers.smtp.host')) {
            Mail::send('mail.order', $data, function($message) use ($to_name, $to_email){
                $message->to($to_email)->subject('Test mail gg');
                $message->from($to_email, $to_name);
            });

            return redirect('home')->with('message', '');
        } else {
            // Xử lý khi cấu hình email không đúng
            return redirect('home')->with('message', 'Cấu hình email không đúng');
        }
    }
}
