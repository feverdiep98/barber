<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckOutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|alpha|min:3|max:255|string|unique:name',
            'email' => 'required|email|unique:users,email|regex:/^\S+@\S+$/u',
            'phone' => 'required|numeric|min:9|unique:phone',
            'address' =>'required|alpha_dash',
            'date' =>'required|date_format:d/m/Y',
            'town'=> 'required',
        ];
    }
    public function messages(): array
    {
        return[

                'name.required' => 'Ten user bat buoc phai nhap!',
                'name.unique' => 'Ten da co nguoi su dung',
                'email.regex' => 'Email không được có khoảng trắng',
                'email.unique' => 'Email da co nguoi su dung',
                'email.required' => 'Email bat buoc phai nhap!',
                'email.email' => 'Email khong dung dinh dang',
                'phone.required' => 'so dien thoai bat buoc phai nhap!',
                'phone.unique' => 'so dien thoai bị trùng nhau',
                'phone.numeric' => 'so dien thoai phai dang chu so',
                'address.required' => 'Dia Chi bat buoc phai nhap!',
                'address.alpha_dash' => 'Khong dung dinh dang',
                'date.required' => 'Xin vui long nhap ngay thang nam',
                'date.date_format:d/m/Y' => 'Xin vui long nhap dung dinh dang ngay thang nam',
                'town.required' => 'Bat buoc phai chon!',
        ];
    }
}
