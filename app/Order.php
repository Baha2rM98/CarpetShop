<?php

namespace App;

use App\Helper\CustomSoftDeletes\CustomSoftDeletes;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @property mixed price
 * @property mixed status
 * @property mixed order_code
 * @property mixed product_postcode
 * @property mixed user_id
 * @property mixed pure_price
 * @property mixed discount_price
 * @property mixed coupon_id
 * @property mixed coupon_discount
 * @property mixed id
 * @property mixed address_id
 */
class Order extends Model
{
    use CustomSoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Returns a many-to-many relationship with Product
     * @return Relation
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withPivot('quantity')->withTimestamps();
    }

    /**
     * Returns a one-to-many relationship with User
     * @return Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns a one-to-many relationship with Coupon
     * @return Relation
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Returns a one-to-many relationship with Address
     * @return Relation
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Returns a one-to-one relationship with Payment
     * @return Relation
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }

    /**
     * Converts gregorian date format to jalali
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return (new Verta($value))->format('%d %B %Y');
    }
}
