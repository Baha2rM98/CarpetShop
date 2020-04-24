<?php

namespace App;

use BlackPlatinum\SoftDeletesFix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed title
 * @property mixed code
 * @property mixed price
 * @property mixed status
 */
class Coupon extends Model
{
//    use SoftDeletesFix;
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'code', 'price', 'status'
    ];

    /**
     * Returns a many-to-many relationship with User
     * @return Relation
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'coupon_user', 'coupon_id', 'user_id')->withTimestamps();
    }

    /**
     * Returns a one-to-many relationship with Order
     * @return Relation
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'coupon_id');
    }
}
