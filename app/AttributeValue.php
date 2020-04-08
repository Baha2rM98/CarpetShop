<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed title
 * @property mixed attribute_group_id
 */
class AttributeValue extends Model
{
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
    protected $fillable = ['title', 'attribute_group_id'];

    /**
     * Returns a one-to-many relationship with AttributeGroup
     * @return Relation
     */
    public function attributeGroup()
    {
        return $this->belongsTo(AttributeGroup::class);
    }

    /**
     * Returns a many-to-many relationship with Product
     * @return Relation
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'attributevalue_product', 'attribute_value_id', 'product_id');
    }
}
