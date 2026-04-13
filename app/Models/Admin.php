<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $connection = 'mongodb';
    protected $collection = 'admins';

    protected $fillable = [
        'name',
        'email',
        'username',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public $timestamps = true;
}