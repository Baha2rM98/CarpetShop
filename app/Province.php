<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Province extends Model
{
    /**
     * Returns a one-to-many relationship with City
     * @return Relation
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'province_id');
    }
}
