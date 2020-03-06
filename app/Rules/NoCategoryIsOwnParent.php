<?php

namespace App\Rules;

use App\Category;
use Illuminate\Contracts\Validation\Rule;

class NoCategoryIsOwnParent implements Rule
{
    private $id;

    /**
     * Create a new rule instance.
     *
     * @param  int  $id
     */
    public function __construct($id)
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
        return Category::findOrFail($this->id)->id != $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'هیچ دسته بندی نمیتواند والد خود باشد!';
    }
}
