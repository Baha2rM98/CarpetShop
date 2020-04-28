<?php

namespace App;

//use BlackPlatinum\SoftDeletesFix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
//    use SoftDeletesFix;
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Returns a one-to-many relationship with Province
     * @return Relation
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
