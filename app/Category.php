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
}
