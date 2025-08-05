<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mention extends Model
{
    protected $fillable = [
    'mentionable_id',
    'mentionable_type',
    'mentioned_user_id',
];
    use HasFactory;

    public function mentionable() {
        return $this->morphTo();
    }

    public function mentionedUser() {
        return $this->belongsTo(User::class, 'mentioned_user_id');
    }
}
