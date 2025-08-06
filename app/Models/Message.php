<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// app/Models/Message.php
// app/Models/Message.php
class Message extends Model
{
    protected $fillable = ['sender_id', 'content', 'image_path'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipients()
    {
        return $this->belongsToMany(User::class, 'message_user', 'message_id', 'recipient_id');
    }
}