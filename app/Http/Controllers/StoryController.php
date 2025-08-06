<?php

// app/Http/Controllers/StoryController.php

// app/Http/Controllers/StoryController.php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use FFMpeg\FFProbe;
use FFMpeg\Exception\RuntimeException;

class StoryController extends Controller
{
    public function create()
    {
        return view('stories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:jpg,jpeg,png,gif,mp4|max:10240',
            'caption' => 'nullable|string|max:200',
        ]);

        $file = $request->file('media');
        $path = $file->store('stories', 'public');
        $type = $file->extension() === 'mp4' ? 'video' : 'photo';

        $duration = null;

        if ($type === 'video') {
            $duration = $this->getVideoDuration(Storage::disk('public')->path($path));
            if ($duration > 15) {
                Storage::disk('public')->delete($path);
                return back()->with('error', 'El video no puede superar los 15 segundos.');
            }
        }

        $story = Story::create([
            'user_id' => Auth::id(),
            'media_path' => $path,
            'type' => $type,
            'caption' => $request->caption,
            'duration' => $duration,
            'expires_at' => now()->addHours(24),
        ]);

        // Detectar menciones (@usuario)
        $this->parseMentions($request->caption, $story);

        return redirect()->route('dashboard')->with('status', 'Historia publicada.');
    }

    public function index()
    {
        $followingIds = Auth::user()->follows->pluck('id');
        $stories = Story::whereIn('user_id', $followingIds)
            ->where('expires_at', '>', now())
            ->with('user')
            ->get()
            ->groupBy('user_id');

        return view('dashboard', compact('stories'));
    }

    public function view(Story $story)
    {
        if ($story->expires_at < now()) {
            abort(404);
        }

        $story->views()->firstOrCreate([
            'viewer_id' => Auth::id(),
        ]);

        return response()->json(['viewed' => true]);
    }

    public function react(Story $story, Request $request)
    {
        $request->validate(['emoji' => 'required|string|max:10']);

        $story->reactions()->updateOrCreate(
            ['user_id' => Auth::id()],
            ['emoji' => $request->emoji]
        );

        return back()->with('status', 'Reacción enviada.');
    }

    
private function getVideoDuration(string $path): float
{
    try {
        $ffprobe  = FFProbe::create();
        $format   = $ffprobe->format($path);
        $duration = $format->get('duration');

        return (float) $duration;
    }
    // Opción A: catch específico de PHP-FFMpeg
    catch (RuntimeException $e) {
        // Log::warning("FFProbe runtime error: " . $e->getMessage());
        return 0;
    }
    // Opción B: catch genérico si no te importa el tipo
    catch (\Throwable $e) {
        return 0;
    }
}

    private function parseMentions($content, $model)
    {
        if (!$content) return;

        preg_match_all('/@([a-zA-Z0-9_]+)/', $content, $matches);
        foreach ($matches[1] as $username) {
            $user = \App\Models\User::where('username', $username)->first();
            if ($user && $user->id !== Auth::id()) {
                \App\Models\Mention::firstOrCreate([
                    'mentionable_id' => $model->id,
                    'mentionable_type' => get_class($model),
                    'mentioned_user_id' => $user->id,
                ]);
            }
        }
    }
}