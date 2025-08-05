<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{

    protected $fillable = [
    'user_id',
    'media_path',
    'type',
    'caption',
    'duration',
    'expires_at',
];
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function views() {
        return $this->hasMany(StoryView::class);
    }

    public function reactions() {
        return $this->hasMany(Reaction::class);
    }

    public function mentions() {
        return $this->morphMany(Mention::class, 'mentionable');
    }
}
