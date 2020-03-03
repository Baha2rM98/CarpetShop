<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBrandRequest extends FormRequest
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
            'title' => ['required', 'min:2', 'unique:brands'],
            'description' => ['required', 'max:10000'],
            'photo_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'نام برند نمیتواند خالی باشد!',
            'title.min' => 'نام برند نمیتواند کمتر از 2 کاراکتر باشد!',
            'title.unique' => 'این برند قبلا ثبت شده است!',
            'description.required' => 'توضیحات برند نمیتواند خالی باشد!',
            'description.max' => 'توضیحات برند نمیتواند بیشتر از 10000 کاراکتر باشد!',
            'photo_id.required' => 'عکس برند نمیتواند خالی باشد!'
        ];
    }
}
