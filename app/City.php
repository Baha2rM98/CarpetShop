<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class City extends Model
{
    /**
     * Returns a one-to-many relationship with Province
     * @return Relation
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
