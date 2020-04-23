<?php

namespace App;

use App\Helper\CustomSoftDeletes\CustomSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use CustomSoftDeletes;

    /**
     * The attributes that should be mutated to dates
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Returns a one-to-many relationship with City
     * @return Relation
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'province_id');
    }
}
