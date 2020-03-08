<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @property mixed title
 * @property mixed sku
 * @property mixed slug
 * @property mixed status
 * @property mixed price
 * @property mixed discount_price
 * @property mixed description
 * @property mixed brand_id
 * @property mixed user_id
 */
class Product extends Model
{
    /**
     * Returns a many-to-many relationship with Category
     * @return Relation
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    /**
     * Returns a one-to-many relationship with Brand
     * @return Relation
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
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
     * Returns a many-to-many relationship with AttributeValue
     * @return Relation
     */
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'attributevalue_product', 'product_id',
            'attribute_value_id');
    }

    /**
     * Returns a many-to-many relationship with Photos
     * @return Relation
     */
    public function photos()
    {
        return $this->belongsToMany(Photo::class, 'photo_product', 'product_id',
            'photo_id');
    }
}
