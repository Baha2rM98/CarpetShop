<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @property mixed parent_id
 * @property mixed name
 * @property mixed meta_title
 * @property mixed meta_desc
 * @property mixed meta_keywords
 */
class Category extends Model
{
    /**
     * Returns children of each category recursively
     * @return Relation
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }

    /**
     * Returns a one-to-many relationship with Product
     * @return Relation
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * Returns a one-to-many relationship with AttributeGroup
     * @return Relation
     */
    public function attributesGroup()
    {
        return $this->hasMany(AttributeGroup::class);
    }
}
