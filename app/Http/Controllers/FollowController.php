<?php

// app/Http/Controllers/FollowController.php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\FollowerNotification;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', 'No puedes seguirte a ti mismo.');
        }

        $exists = Follow::where('follower_id', Auth::id())
            ->where('followed_id', $user->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Ya sigues a este usuario.');
        }

        Follow::create([
            'follower_id' => Auth::id(),
            'followed_id' => $user->id,
        ]);

        // Enviar notificación por correo
        Mail::to($user->email)->queue(new FollowerNotification(Auth::user()));

        return back()->with('status', 'Ahora sigues a @' . $user->username);
    }

    public function unfollow(User $user)
    {
        Follow::where('follower_id', Auth::id())
            ->where('followed_id', $user->id)
            ->delete();

        return back()->with('status', 'Dejaste de seguir a @' . $user->username);
    }
}