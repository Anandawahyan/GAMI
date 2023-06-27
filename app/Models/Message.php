<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $primaryKey = 'id';

    protected $fillable = [
        'message_text',
        'user_id',
        'message_reference_id',
        'message_title',
        'is_solved'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
