<?php

// app/Http/Controllers/StoryController.php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\StoryView;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use FFMpeg\FFProbe;
class StoryController extends Controller
{
    public function index()
    {
        $followingIds = Auth::user()->follows->pluck('id');
        $stories = Story::whereIn('user_id', $followingIds)
            ->where('expires_at', '>', now())
            ->with('user')
            ->get()
            ->groupBy('user_id');

        return view('stories.index', compact('stories'));
    }

    public function create()
    {
        return view('stories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:jpg,jpeg,png,gif,mp4|max:10240',
        ]);

        $path = $request->file('media')->store('stories', 'public');
        $type = $request->file('media')->extension() === 'mp4' ? 'video' : 'photo';

        // Validar duración si es video
        if ($type === 'video') {
            $duration = $this->getVideoDuration(Storage::disk('public')->path($path));
            if ($duration > 15) {
                Storage::disk('public')->delete($path);
                return back()->with('error', 'El video no puede superar los 15 segundos.');
            }
        }

        Story::create([
            'user_id' => Auth::id(),
            'media_path' => $path,
            'type' => $type,
            'caption' => $request->caption,
            'duration' => $type === 'video' ? $duration : null,
            'expires_at' => now()->addHours(24),
        ]);

        return redirect()->route('dashboard')->with('status', 'Historia publicada.');
    }

    public function view(Story $story)
    {
        if ($story->expires_at < now()) {
            abort(404);
        }

        StoryView::firstOrCreate([
            'story_id' => $story->id,
            'viewer_id' => Auth::id(),
        ]);

        return response()->json(['viewed' => true]);
    }

    public function react(Story $story, Request $request)
    {
        $request->validate(['emoji' => 'required|string|max:10']);

        Reaction::updateOrCreate(
            ['story_id' => $story->id, 'user_id' => Auth::id()],
            ['emoji' => $request->emoji]
        );

        return back()->with('status', 'Reacción enviada.');
    }

 private function getVideoDuration(string $path): int
{
    try {
        $ffprobe  = FFProbe::create();
        $duration = (int) $ffprobe
            ->format($path)      // obtiene información de formato
            ->get('duration');   // extrae la duración en segundos

        return $duration;
    } catch (\Exception $e) {
        // opcionalmente loguea $e->getMessage()
        return 0;
    }
}
}