<?php

namespace App\Http\Controllers\Admin;

use App\Events\CheckUserSwitchStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Pipeline;

class AdminController extends Controller
{
    public function logon(){
        return view('admin.login');
    }
    public function access(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 1])){
            $user = Auth::user();

            // Kiểm tra trạng thái active của tài khoản
            if ($user->active) {
                return redirect()->route('admin.chart');
            } else {
                Auth::logout();
                // Tài khoản không được kích hoạt, hiển thị thông báo
                return redirect()->route('admin.login')->with('status', 'Tài khoản của bạn chưa được kích hoạt hoặc đã nghĩ việc.');
            }

        }

        // Thông báo đăng nhập không thành công
        return redirect()->route('403');
    }
    public function signout(){
        Auth::logout();
        return redirect()->route('logon');
    }
    public function index(Request $request){
        $pinelines = [
            \App\Filters\ByKeyword::class,
        ];
        $pineline = Pipeline::send(User::query())
        ->through($pinelines)
        ->thenReturn();
        $users = $pineline->paginate(config('myconfig.item_per_page'));
        return view('admin.user.index',['users' => $users]);
    }
    public function create(){
        return view('admin.user.create');
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password',
            'role' => 'required|in:admin,user',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $fileName= null;
        if($request->hasFile('image_url')){
            $originName = $request->file('image_url')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('image_url')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('image_url')->move(public_path('images'),$fileName);
        }

        //Eloquent ORM
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password'=> Hash::make($request->password),
            'role' => $request->role,
            'image_url' => $fileName,
        ]);
        $msg = $user ? 'Welcome to new Member': 'Create Member Failed';
        return redirect()->route('admin.user.index')->with('message',$msg);
    }
    public function update(Request  $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password',
            'role' => 'required|in:admin,user',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
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
            $check= User::where('id',$request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password'=> Hash::make($request->password),
                'role' => $request->role,
            ]);

            $msg = $check ? 'Update User Success': 'Update User Failed';
            return redirect()->route('admin.user.index')->with('message',$msg);
    }
    public function detail($id){
        $user = User::find($id);
        return view('admin.user.detail',compact('user'));
    }
    public function destroy($id){
        $check = User::where('id',$id)->delete();

        $msg = $check ? 'Delete User Success': 'Delete User Failed';
        return redirect()->route('admin.user.index')->with('message',$msg);
    }

    public function activateUser(Request $request, $userId)
    {
        $user = User::find($userId);

        if ($user) {
            $updateData = [
                'active' => $request->input('active', 0),
            ];

            $check = $user->update($updateData);
            return response()->json(['message' => $check ? 'Cập nhật tài khoản thành công' : 'Không có sự thay đổi']);
        } else {
            return response()->json(['message' => 'Không tìm thấy người dùng'], 404);
        }
    }
    public function deleteAll(Request $request){
        $ids = $request->id;
        foreach($ids as $id){
            $check = User::where('id', $id)->delete();
        }
        $msg = $check ? 'Delete User Success': 'Delete User Failed';
        return redirect()->route('admin.user.index')->with('message',$msg);
    }
}
