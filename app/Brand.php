<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @property mixed title
 * @property mixed description
 * @property mixed photo_id
 */
class Brand extends Model
{
    /**
     * Creates a one-to-one relation with Photo
     * @return Relation
     */
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
}
