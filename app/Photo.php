<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @property mixed original_name
 * @property mixed path
 * @property mixed user_id
 * @property mixed id
 */
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
