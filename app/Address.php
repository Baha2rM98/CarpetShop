<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Address extends Model
{
    /**
     * Returns a one-to-many relationship with User
     * @return Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
