<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /* attributes */
    protected $fillable = [
        'email',
    ];
    protected $hidden = [
        'password',
    ];
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
    protected $table = 'users';

    /* relationships */
    public function posts()
    {
        return $this->hasMany('App\Post', 'id_user');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'id_user');
    }
}
