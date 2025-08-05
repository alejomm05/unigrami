<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render()
    {

   // Obtener historias recientes de usuarios seguidos
        $stories = Auth::user()->follows
            ->flatMap(function ($user) {
                return $user->stories()->where('expires_at', '>', now())->get();
            })
            ->take(5);

        // Obtener publicaciones de usuarios seguidos
        $posts = Auth::user()->follows
            ->flatMap(function ($user) {
                return $user->posts;
            });

        return view('livewire.dashboard', [
            'stories' => $stories,
            'posts' => $posts,
        ]);
    }
}