<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed address
 * @property mixed company
 * @property mixed post_code
 * @property mixed province_id
 * @property mixed city_id
 * @property mixed user_id
 */
class Address extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company',
        'address',
        'post_code',
        'province_id',
        'city_id'
    ];

    /**
     * Returns a one-to-many relationship with User
     * @return Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
