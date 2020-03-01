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
        return $this->belongsTo(AttributeGroup::class, 'attribute_group_id');
    }
}
