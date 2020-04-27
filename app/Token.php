<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed token
 * @property mixed expired
 */
class Token extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['token', 'expired'];
}
