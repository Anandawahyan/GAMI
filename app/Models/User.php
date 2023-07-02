<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Order;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'address',
        'sex',
        'job',
        'phone_number',
        'role',
        'points'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
}
