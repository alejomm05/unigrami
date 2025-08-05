<?php

// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Mention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'caption' => 'nullable|string|max:200',
        ]);

        $path = $request->file('image')->store('posts', 'public');

        $post = Post::create([
            'user_id' => Auth::id(),
            'image_path' => $path,
            'caption' => $request->caption,
        ]);

        // Detectar menciones
        $this->parseMentions($request->caption, $post);

        return redirect()->route('dashboard')->with('status', '¡Publicación creada!');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'mentions.mentionedUser']);
        return view('posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        // Verificar que el usuario logueado sea el dueño del post
        if (Auth::id() !== $post->user_id) {
            abort(403, 'No estás autorizado para eliminar esta publicación.');
        }

        $post->delete();

        return back()->with('status', 'Publicación eliminada correctamente.');
    }

    // Método privado para detectar menciones
    private function parseMentions($content, $model)
    {
        if (!$content) return;

        preg_match_all('/@([a-zA-Z0-9_]+)/', $content, $matches);
        foreach ($matches[1] as $username) {
            $mentionedUser = User::where('username', $username)->first();
            if ($mentionedUser && $mentionedUser->id !== Auth::id()) {
                Mention::firstOrCreate([
                    'mentionable_id' => $model->id,
                    'mentionable_type' => get_class($model),
                    'mentioned_user_id' => $mentionedUser->id,
                ]);
            }
        }
    }
}