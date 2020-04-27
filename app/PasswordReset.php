<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed phone
 * @property mixed token
 * @property mixed expired
 */
class PasswordReset extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'password_resets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['expired'];
}
