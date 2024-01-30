<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductCategoryRequest extends FormRequest
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
            'name' => 'required|min:3|max:255|string|unique:product_category,name',
            'status' => 'boolean|string'
        ];
    }
    public function messages(): array
    {
        return[
            'name.unique' => 'Ten da duoc su dung',
            'name.required' => 'Ten category bat buoc phai nhap!',
            'status.required' => 'Chua chon Status!'
        ];
    }
}
