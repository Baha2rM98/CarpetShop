<?php

namespace App\Http\Requests;

use App\Rules\CheckUniqueSlugForProduct;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'title' => ['bail', 'required', 'min:2', 'max:100'],
            'slug' => ['bail', 'required', new CheckUniqueSlugForProduct(), 'max:100'],
            'categories' => 'required|array',
            'brand' => 'required',
            'status' => 'required',
            'price' => ['bail', 'required', 'numeric', 'digits_between:1,15', 'gt:discount_price'],
            'discount_price' => ['bail', 'nullable', 'numeric', 'digits_between:1,15'],
            'description' => ['bail', 'required', 'max:100000'],
            'photo_id.*' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'نام محصول نمیتواند خالی باشد!',
            'title.min' => 'نام محصول نمیتواند کمتر از 2 کاراکتر باشد!',
            'title.max' => 'نام محصول نمیتواند بیشتر از 100 کاراکتر باشد!',
            'slug.required' => 'نام مستعار محصول نمیتواند خالی باشد!',
            'slug.max' => 'نام مستعار محصول نمیتواند بیشتر از 100 کاراکتر باشد!',
            'categories.required' => 'هر محصول باید حداقل متعلق به یک دسته بندی باشد!',
            'brand.required' => 'هر محصول باید متعلق به یک برند باشد!',
            'status.required' => 'وضعیت محصول باید درج شود!',
            'price.required' => 'قیمت محصول نمیتواند خالی باشد!',
            'price.numeric' => 'قیمت محصول باید از نوع عدد باشد!',
            'price.digits_between' => 'قیمت وارد شده بزرگ تر از حد مجاز است!',
            'price.gt' => 'قیمت ویژه محصول نمیتواند از قیمت اصلی آن بزرگتر یا برابر باشد!',
            'discount_price.numeric' => 'قیمت ویژه محصول باید از نوع عدد باشد!',
            'discount_price.digits_between' => 'قیمت ویژه وارد شده بزرگ تر از حد مجاز است!',
            'description.required' => 'توضیحات محصول نمیتواند خالی باشد!',
            'description.max' => 'توضیحات محصول نمیتواند بیشتر ار 100000 کاراکتر باشد!',
            'photo_id.*.required' => 'عکس محصول نمیتواند خالی باشد!'
        ];
    }
}
