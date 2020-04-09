<?php

namespace App;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed user_id
 * @property mixed product_id
 */
class Comment extends Model
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
    protected $fillable = ['comment'];

    /**
     * Returns a one-to-many relationship with User
     * @return Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns a one-to-many relationship with Product
     * @return Relation
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Converts gregorian date format to jalali
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return (new Verta($value))->formatDate();
    }
}
