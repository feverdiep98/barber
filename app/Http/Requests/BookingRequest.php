<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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

            'visitor_name' => 'required|string|max:255',
            'visitor_email' => 'required|email|max:255',
            'phone' => 'required|numeric|min:9',
            'booking_time' =>'required',
            'booking_date' => 'required|date|after:today',
            'services' => 'required|string|max:255',
            'slot' => 'required|integer|min:1|max:3',
            'visitor_message' => 'nullable|string',
        ];
    }
    public function messages()
    {
        return [
            'phone.numeric' => 'Vui lòng nhập định dạng số.',
            'phone.required' => 'Vui lòng nhập sdt của bạn.',
            'phone.min' => 'sdt ít nhất 9 số.',
            'booking_time.required' => 'Vui lòng chọn thời gian của bạn.',
            'visitor_name.required' => 'Vui lòng nhập tên của bạn.',
            'visitor_email.required' => 'Vui lòng nhập địa chỉ email của bạn.',
            'visitor_email.email' => 'Địa chỉ email không hợp lệ.',
            'booking_date.required' => 'Vui lòng chọn ngày đặt lịch.',
            'booking_date.after' => 'Vui lòng không chọn ngày hiện tại.',
            'services.required' => 'Vui lòng chọn loại dịch vụ.',
            'slot.required' => 'Vui lòng nhập số lượng.',
            'slot.integer' => 'Số lượng phải là một số nguyên.',
            'slot.max' => 'Bạn chỉ có thể đặt tối đa 3 người',
            // Các thông báo lỗi khác
        ];
    }
}
