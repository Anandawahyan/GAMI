<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'activity',
        'type',
        'created_at',
        'updated_at'
    ];
}
