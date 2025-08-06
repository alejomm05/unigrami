<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'display_name',
        'email',
        'password',
        'profile_image',
        'bio',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function follows()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'follower_id',
            'followed_id'
        )->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'followed_id',
            'follower_id'
        )->withTimestamps();
    }

       // Método para verificar si el usuario sigue a otro
    public function isFollowing(User $user): bool
    {
        return $this->follows()->where('followed_id', $user->id)->exists();
    }

       public function isFollowedBy($user)
    {
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

   // app/Models/User.php
public function sentMessages()
{
    return $this->hasMany(Message::class, 'sender_id');
}

public function receivedMessages()
{
    return $this->belongsToMany(Message::class, 'message_user', 'recipient_id', 'message_id')
                ->withPivot('read')
                ->withTimestamps();
}


// Verifica si un usuario puede recibir mensajes de otro
public function canReceiveFrom(User $sender)
{
    return $this->followers()->where('follower_id', $sender->id)->exists();
}

    public function mentions()
    {
        return $this->hasMany(Mention::class, 'mentioned_user_id');
    }

    public function notifications()
    {
        return $this->morphMany(\Illuminate\Notifications\DatabaseNotification::class, 'notifiable');
    }

    public function storyViews()
    {
        return $this->hasMany(StoryView::class, 'viewer_id');
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function comments()
{
    return $this->hasMany(Comment::class);
}


}