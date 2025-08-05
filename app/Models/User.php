<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable


{
    protected $fillable = [
    'username',
    'display_name',
    'email',
    'password',
    'profile_image',
];

    use HasFactory, Notifiable;

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function stories() {
        return $this->hasMany(Story::class);
    }

    public function follows() {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    public function followers() {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    public function sentMessages() {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages() {
        return $this->belongsToMany(Message::class, 'message_user', 'recipient_id', 'message_id');
    }

    public function mentions() {
        return $this->hasMany(Mention::class, 'mentioned_user_id');
    }

    public function notifications() {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function storyViews() {
        return $this->hasMany(StoryView::class, 'viewer_id');
    }

    public function reactions() {
        return $this->hasMany(Reaction::class);
    }
}
