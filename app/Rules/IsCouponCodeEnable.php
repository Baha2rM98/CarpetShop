<?php

namespace App\Rules;

use App\Coupon;
use Illuminate\Contracts\Validation\Rule;

class IsCouponCodeEnable implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
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
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Coupon::where('code', $value)->first()->status === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'کد تخفیف وارد شده غیر فعال است!';
    }
}
