<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        // Kiểm tra xem người dùng đã đăng nhập bằng Google chưa
        if ($request->has('code')) {
            // Người dùng đã đăng nhập bằng Google, xử lý theo callback của Google
            $googleUser = Socialite::driver('google')->user();

            // Thực hiện xác thực hoặc đăng ký người dùng với thông tin từ Google
            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'google_user_id' => $googleUser->id,
                    'password' => Hash::make('password' . '@' . $googleUser->email),
                ]
            );

            Auth::login($user);

            return redirect()->route('home.product');
        }

        // Người dùng không đăng nhập bằng Google, xử lý thông tin đăng nhập thông thường
        if ($request->isMethod('post')) {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                // Nếu xác thực thành công, chuyển hướng đến trang chính
                return redirect()->route('home.product');
            } else {
                // Nếu xác thực thất bại, hiển thị thông báo lỗi
                return back()->with('error', 'Đăng nhập thất bại. Vui lòng kiểm tra lại email và mật khẩu.');
            }
        }

        // Người dùng không submit form, hiển thị trang callback hoặc trang đăng nhập
        return view('client.pages.registers.account'); // Thay thế 'callback' bằng tên trang callback hoặc đăng nhập của bạn
    }
}
