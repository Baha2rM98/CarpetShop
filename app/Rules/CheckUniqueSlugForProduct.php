<?php

namespace App\Rules;

use App\Http\Controllers\Backend\ProductController;
use App\Product;
use Illuminate\Contracts\Validation\Rule;

class CheckUniqueSlugForProduct implements Rule
{
    private $id;

    /**
     * Create a new rule instance.
     *
     * @param  int  $id
     */
    public function __construct($id = null)
    {
        $this->id = $id;
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
        if (isset($this->id)) {
            return true;
        }

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
