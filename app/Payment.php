<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed authority
 * @property mixed status
 * @property mixed refId
 * @property mixed order_id
 */
class Payment extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('id', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });
    }

    /**
     * Returns a one-to-one relationship with Order
     * @return Relation
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
