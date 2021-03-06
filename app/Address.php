<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
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
 * @property mixed primary
 */
class Address extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('id', function (Builder $builder) {
            $builder->orderBy('addresses.id', 'asc');
        });
    }

    /**
     * Returns a one-to-many relationship with User
     * @return Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns a one-to-many relationship with Province
     * @return Relation
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Returns a one-to-many relationship with City
     * @return Relation
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
