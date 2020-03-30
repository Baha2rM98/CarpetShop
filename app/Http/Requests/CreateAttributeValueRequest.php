<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAttributeValueRequest extends FormRequest
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
            'attribute_group_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'مقدار ویژگی نمیتواند خالی باشد!',
            'title.max' => 'مقدار ویژگی نمیتواند بیشتر از 50 کاراکتر باشد!',
            'title.min' => 'مقدار ویژگی نمیتواند کمتر از 2 کاراکتر باشد!',
            'attribute_group_id.required' => 'ویژگی نمیتواند خالی باشد!',
        ];
    }
}
