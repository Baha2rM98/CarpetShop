<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed original_name
 * @property mixed path
 * @property mixed user_id
 * @property mixed id
 */
class Photo extends Model
{
    use SoftDeletes;

    /**
     * @var string Public path
     */
    protected $uploads = '/storage/photos/';

    /** Returns symbolic link path of the photo
     *
     * @param  string  $photo
     *
     * @return string
     */
    public function getPathAttribute($photo)
    {
        return $this->uploads.$photo;
    }
}
