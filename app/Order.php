<?php

namespace App;

use App\Helper\CustomSoftDeletes\CustomSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id');
    }

    /**
     * Returns a one-to-many relationship with User
     * @return Relation
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
