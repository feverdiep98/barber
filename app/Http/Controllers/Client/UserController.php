<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return view('client.pages.registers.account');
    }
    public function saveUser(Request $request){
        $request->validate([
            'email' => 'required|min:3|max:100|email',
            'name' => 'required|min:3|max:100',
            'password' => 'required|min:3|max:100',
        ],
        [
            'email.email' => 'Email nhap sai dinh dang roi!',
            'email.required' => 'Nhap Email deeeeeee!',
            'email.min' => 'Email it nhat 3 ky tu!',
            'email.max' => 'Email nhieu nhat 255 ky tu!',
        ]);

        //validate Request
        $password = Hash::make($request->password);
        $request = DB::insert('INSERT INTO users(name, email, password)
        VALUES(?,?,?)', [$request->name,$request->email, $password]);

        return redirect('dangky')->with('message','sign up success');
    }

    public function signIn(Request $request){
        $request->validate([
            'email'=>['required','email'],
            'password'=>['required'],
        ]);

        // Sử dụng Auth để kiểm tra thông tin đăng nhập
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            // Nếu đăng nhập thành công, bạn có thể sử dụng hàm auth()->user() để lấy thông tin người dùng
            session()->push('users', ['id' => auth()->user()->id, 'email' => auth()->user()->email, 'name' => auth()->user()->name]);

            return redirect()->route('home')->with('message', 'Sign in success');
        }

        return back()->with('error', 'Email | Password is Wrong');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home');
    }



}
