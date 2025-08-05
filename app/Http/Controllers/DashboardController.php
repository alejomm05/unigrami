<?php

// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Historias de usuarios seguidos
        $followingIds = Auth::user()->follows->pluck('id');
        $stories = Story::whereIn('user_id', $followingIds)
            ->where('expires_at', '>', now())
            ->with('user')
            ->get()
            ->groupBy('user_id');

        // Publicaciones de usuarios seguidos
        $posts = Post::whereIn('user_id', $followingIds)
        ->with(['user', 'comments.user'])
        ->latest()
        ->paginate(10);

        // Sugerencias: usuarios con más seguidores (excluyéndose a sí mismo)
        $suggestions = User::whereNotIn('id', $followingIds->merge([Auth::id()]))
            ->withCount('followers')
            ->orderByDesc('followers_count')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stories', 'posts', 'suggestions'));
    }
}