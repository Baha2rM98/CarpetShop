<?php

namespace App;

use App\Helper\CustomSoftDeletes\CustomSoftDeletes;
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
    use CustomSoftDeletes;

    /**
     * The attributes that should be mutated to dates
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Returns a one-to-one relationship with Order
     * @return Relation
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
