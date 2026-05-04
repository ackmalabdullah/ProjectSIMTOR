<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Users extends Model implements AuthenticatableContract, JWTSubject
{
    use Authenticatable;

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

        // 🔥 tambahan penting
        'role',
        'provider',
        'firebase_uid',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'gaji_per_bulan' => 'integer',
    ];

    // 🔥 JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
