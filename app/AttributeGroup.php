<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @property mixed title
 * @property mixed type
 */
class AttributeGroup extends Model
{
    protected $table = 'attributes_group';

    /**
     * Returns a one-to-many relationship with AttributeValue
     * @return Relation
     */
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_group_id');
    }

    /**
     * Returns a many-to-many relationship with Category
     * @return Relation
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'attributegroup_category', 'attribute_group_id', 'category_id');
    }
}
