<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;

    protected $table = 'alamat';

    protected $primaryKey = 'id';

    protected $fillable = [
        'alamat_rumah',
        'ongkir',
        'user_id',
        'id_kota',
        'alamat_rumah',
        'shipping_time'
    ];
}
