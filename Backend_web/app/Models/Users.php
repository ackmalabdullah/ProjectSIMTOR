<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Users extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'no_telp',
        'alamat',
        'pekerjaan',
        'gaji_per_bulan',
        'status',
    ];

    protected $hidden = [
        'password',
    ];
}