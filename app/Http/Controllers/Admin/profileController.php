<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class profileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.users.profile', compact('user'));
    }
    public function update(Request $request){
        $validator = FacadesValidator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone' => 'required|string|max:20',
            'dob' => 'required|date_format:Y-m-d',
            'password' => 'nullable|string|min:6',
            'newPassword' => 'nullable|string|min:6',
            'confirm_password' => 'nullable|same:newPassword',
            'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // Maximum file size: 5MB
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.users.profile')->withErrors($validator)->withInput();
        }
        if(isset($request->image_url)){
            $fileName = $request->image_url; // Giữ lại tên file cũ nếu không có hình mới
            if ($request->hasFile('image_url')) {
                // Nếu có hình mới, thực hiện xử lý
                $originName = $request->file('image_url')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('image_url')->getClientOriginalExtension();
                $fileName = $fileName . '_' . time() . '.' . $extension;

                $request->file('image_url')->move(public_path('images'), $fileName);

                // Xóa hình cũ nếu tên file cũ tồn tại và khác tên file mới
                if (!is_null($request->image_url) && $request->image_url !== $fileName && file_exists("images/" . $request->image_url)) {
                    unlink("images/" . $request->image_url);
                }
            }
            $check = User::where('id', $request->id)->update(['image_url' => $fileName]);
        }

        // Tiếp tục xử lý dữ liệu và cập nhật vào CSDL
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $request->dob,
        ];

        if ($request->filled('newPassword')) {
            // Cập nhật mật khẩu mới
            $userData['password'] = bcrypt($request->input('newPassword'));
        }
        $check = User::where('id', $request->id)->update($userData);
        $msg = $check ? 'Update User Success': 'Update User Failed';
        return redirect()->route('admin.users.profile')->with('message',$msg);
    }
}
