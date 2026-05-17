<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class SimulasiKredit extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'simulasi_kredit';

    protected $fillable = [
        'user_id',
        'nama_user',

        'motor_id',
        'nama_motor',

        'harga_motor',

        'penghasilan',

        'dp_persen',
        'dp_nominal',

        'tenor',

        'cicilan_per_bulan',

        'persen_gaji',

        'status_kelayakan',
    ];
}