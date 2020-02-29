<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'name' => ['required', 'max:50', 'min:2']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'نام دسته بندی نمیتواند خالی باشد!',
            'name.max' => 'نام دسته بندی نمیتواند بیشتر از 50 کاراکتر باشد!',
            'name.min' => 'نام دسته بندی نمیتواند کمتر از 2 کاراکتر باشد!'
        ];
    }
}
