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
    protected $uploads = '/storage/photos/';

    /**
     * Creates a one-to-many relation with User
     * @return Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Returns symbolic link path of the photo
     *
     * @param string $photo
     * @return string
     */
    public function getPathAttribute($photo)
    {
        return $this->uploads . $photo;
    }
}
