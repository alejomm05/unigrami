<?php

// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Mention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;

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

        return back()->with('status', 'Publicación creada.');
    }

    public function show($id)
    {
        $post = Post::with(['user', 'comments.user', 'mentions.mentionedUser'])->findOrFail($id);
        return view('posts.show', compact('post'));
    }

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