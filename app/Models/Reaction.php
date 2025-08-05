<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reaction extends Model
{
    use HasFactory;

    protected $fillable = [
    'story_id',
    'user_id',
    'emoji',
];
    public function story() {
        return $this->belongsTo(Story::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
