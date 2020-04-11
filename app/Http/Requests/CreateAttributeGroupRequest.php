<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAttributeGroupRequest extends FormRequest
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
            'title' => ['bail', 'required', 'max:50', 'min:2'],
            'type' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'عنوان گروه بندی ویژگی نمیتواند خالی باشد!',
            'title.max' => 'عنوان گروه بندی ویژگی نمیتواند بیشتر از 50 کاراکتر باشد!',
            'title.min' => 'عنوان گروه بندی ویژگی نمیتواند کمتر از 2 کاراکتر باشد!',
            'type.required' => 'نوع گروه بندی ویژگی نمیتواند خالی باشد!'
        ];
    }
}
