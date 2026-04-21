<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Motor extends Model
{
  protected $connection = 'mongodb';
  protected $collection = 'motor';

  protected $fillable = [
    'kode_mpm',
    'nama_motor',
    'merk',
    'tipe',
    'harga',
    'gambar',
    'deskripsi',
    'status'
  ];
}
