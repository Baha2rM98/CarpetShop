<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'max:100'],
            'code' => ['required', 'max:100'],
            'price' => ['required', 'numeric', 'digits_between:1,15'],
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'عنوان کد تخفیف نمیتواند خالی باشد!',
            'title.max' => 'عنوان کد تخفیف نمیتواند بیشتر از 100 کاراکتر باشد!',
            'code.required' => 'کد تخفیف نمیتواند خالی باشد!',
            'code.max' => 'کد تخفیف نمیتواند بیشتر از 100 کاراکتر باشد!',
            'price.required' => 'قیمت کد تخفیف نمیتواند خالی باشد!',
            'price.numeric' => 'قیمت کد تخفیف باید از نوع هدد باشد!',
            'price.digits_between' => 'قیمت کد تخفیف وارد شده بیشتر از حد مجاز است!',
            'status.required' => 'وضعیت کد تخفیف نمیتواند خالی باشد!',
        ];
    }
}
