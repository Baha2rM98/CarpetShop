<?php

namespace App;

use Hekmatinasser\Verta\Verta;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property mixed name
 * @property mixed last_name
 * @property mixed email
 * @property mixed phone_number
 * @property mixed national_code
 * @property mixed password
 */
class User extends Authenticatable
{
    use Notifiable;
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
        'name',
        'last_name',
        'email',
        'phone_number',
        'national_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('id', function (Builder $builder) {
            $builder->orderBy('users.id', 'asc');
        });
    }

    /**
     * Returns a one-to-many relationship with Address
     * @return Relation
     */
    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    /**
     * Returns a many-to-many relationship with Coupon
     * @return Relation
     */
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_user', 'user_id', 'coupon_id')->withTimestamps();
    }

    /**
     * Returns a one-to-many relationship with Comment
     * @return Relation
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    /**
     * Returns a one-to-many relationship with Order
     * @return Relation
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Returns a many-to-many relationship with Product
     * @return Relation
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_user', 'user_id', 'product_id')->withTimestamps();
    }

    /**
     * Converts gregorian date format to jalali
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return (new Verta($value))->formatJalaliDatetime();
    }
}
