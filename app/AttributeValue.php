<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @property mixed title
 * @property mixed attribute_group_id
 */
class AttributeValue extends Model
{
    protected $table = 'attributes_value';

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
