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
    public function attributesValue()
    {
        return $this->hasMany(AttributeGroup::class, 'attribute_group_id');
    }
}
