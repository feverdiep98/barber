<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255|string|unique:name,',                // just a normal required validation
            'email' => 'required|email|unique:ducks',     // required and must be unique in the ducks table
            'phone' => 'reuqired|numberic|unique:phone',
            'password'=> 'required',
            'role'=> 'required',
            'confirm_password' => 'required|same:password'
        ];
    }
    public function messages(): array
    {
        return[
                'name.required' => 'Ten user bat buoc phai nhap!',
                'name.unique' => 'Ten da co nguoi su dung',
                'email.unique' => 'Email da co nguoi su dung',
                'email.required' => 'Email bat buoc phai nhap!',
                'email.email' => 'Email khong dung dinh dang',
                'phone.required' => 'so dien thoai bat buoc phai nhap!',
                'phone.unique' => 'so dien thoai phai dang chu so',
                'password.required' => 'Password bat buoc phai nhap!',
                'confirm_password.required' => 'Xin vui long nhap lai Password',
                'confirm_password.same' => 'Nhap lai mat khau chua dung ',
                'role.required' => 'Role bat buoc phai chon!',
        ];
    }
}
