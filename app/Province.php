<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use SoftDeletes;

    /**
     * Returns a one-to-many relationship with City
     * @return Relation
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'province_id');
    }
}
