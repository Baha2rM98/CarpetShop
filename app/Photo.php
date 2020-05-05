<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed original_name
 * @property mixed path
 * @property mixed id
 */
class Photo extends Model
{
    use SoftDeletes;

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

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('id', function (Builder $builder) {
            $builder->orderBy('photos.id', 'asc');
        });
    }

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
