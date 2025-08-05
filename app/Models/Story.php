<?php
// app/Models/Story.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use App\Models\Reaction;
use App\Models\Mention;

class Story extends Model
{

    protected $fillable = ['user_id', 'media_path', 'type', 'caption', 'duration', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function views()
    {
        return $this->hasMany(StoryView::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function mentions()
    {
        return $this->morphMany(Mention::class, 'mentionable');
    }

    public function getIsActiveAttribute()
    {
        return now()->lessThan($this->expires_at);
    }
}