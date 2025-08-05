<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Mention;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:200',
        ]);

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        // Detectar menciones
        $this->parseMentions($request->content, $comment);

        return back();
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