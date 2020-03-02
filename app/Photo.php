<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Photo extends Model
{
    /**
     * Creates a one-to-many relation with User
     * @return Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
