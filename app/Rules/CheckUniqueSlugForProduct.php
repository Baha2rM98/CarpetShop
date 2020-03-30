<?php

namespace App\Rules;

use App\Http\Controllers\Backend\ProductController;
use App\Product;
use Illuminate\Contracts\Validation\Rule;

class CheckUniqueSlugForProduct implements Rule
{
    /**
     * Create a new rule instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return ! Product::where('slug', ProductController::makeSlug($value))->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'این نام مستعار قبلا ثبت شده است!';
    }
}
