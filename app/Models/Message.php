<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    protected $fillable = [
    'sender_id',
    'content',
    'image_path',
    'original_message_id', 
];

    use HasFactory;

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipients() {
        return $this->belongsToMany(User::class, 'message_user', 'message_id', 'recipient_id');
    }

    public function mentions() {
        return $this->morphMany(Mention::class, 'mentionable');
    }

    public function originalMessage()
{
    return $this->belongsTo(Message::class, 'original_message_id');
}

public function retransmissions()
{
    return $this->hasMany(Message::class, 'original_message_id');
}
}
