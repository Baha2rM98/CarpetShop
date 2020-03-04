<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Product extends Model
{
    /**
     * Returns a one-to-many relationship with Category
     * @return Relation
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
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
}
