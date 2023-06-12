<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $primaryKey = 'id';

    protected $fillable = [
        'message_text',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
