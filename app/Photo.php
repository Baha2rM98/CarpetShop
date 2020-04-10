<?php

namespace App;

use App\Helper\CustomSoftDeletes\CustomSoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed original_name
 * @property mixed path
 * @property mixed user_id
 * @property mixed id
 */
class Photo extends Model
{
    use CustomSoftDeletes;

    /**
     * The attributes that should be mutated to dates
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
