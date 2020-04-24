<?php

namespace App;

use BlackPlatinum\SoftDeletesFix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponUser extends Model
{
//    use SoftDeletesFix;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coupon_user';
}
