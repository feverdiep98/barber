<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckOutRequest extends FormRequest
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
            'customer_name' => 'required|alpha|min:3|max:255|string|unique:name',
            'email' => 'required|email|unique:users,email|regex:/^\S+@\S+$/u',
            'customer_phone' => 'required|numeric|min:9|unique:phone',
            'address' =>'required|alpha_dash',
            'date' =>'required|date_format:d/m/Y',
            'town'=> 'required',
            'note' => 'nullable|string',
        ];
    }
    public function messages(): array
    {
        return[
                'customer_name.required' => 'Ten user bat buoc phai nhap!',
                'customer_name.unique' => 'Ten da co nguoi su dung',
                'email.regex' => 'Email không được có khoảng trắng',
                'email.unique' => 'Email da co nguoi su dung',
                'email.required' => 'Email bat buoc phai nhap!',
                'email.email' => 'Email khong dung dinh dang',
                'customer_phone.required' => 'so dien thoai bat buoc phai nhap!',
                'customer_phone.unique' => 'so dien thoai bị trùng nhau',
                'customer_phone.numeric' => 'so dien thoai phai dang chu so',
                'address.required' => 'Dia Chi bat buoc phai nhap!',
                'address.alpha_dash' => 'Khong dung dinh dang',
                'date.required' => 'Xin vui long nhap ngay thang nam',
                'date.date_format:d/m/Y' => 'Xin vui long nhap dung dinh dang ngay thang nam',
                'town.required' => 'Bat buoc phai chon!',
        ];
    }
}
