<?php

// app/Http/Controllers/MessageController.php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewDirectMessage;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = Message::where('sender_id', Auth::id())
            ->orWhereHas('recipients', fn($q) => $q->where('recipient_id', Auth::id()))
            ->with(['sender', 'recipients'])
            ->latest()
            ->get()
            ->groupBy(function ($message) {
                return $message->sender_id === Auth::id() 
                    ? $message->recipients->first()->id 
                    : $message->sender_id;
            });

        return view('messages.index', compact('conversations'));
    }

    public function conversation($username)
    {
        $recipient = User::where('username', $username)->firstOrFail();
        
        // Validar que el destinatario sigue al emisor
        if (!$recipient->isFollowedBy(Auth::user())) {
            abort(403, 'No puedes enviar mensajes a este usuario.');
        }

        $messages = Message::where(function ($q) use ($recipient) {
            $q->where('sender_id', Auth::id())->whereHas('recipients', fn($r) => $r->where('recipient_id', $recipient->id));
        })->orWhere(function ($q) use ($recipient) {
            $q->where('sender_id', $recipient->id)->whereHas('recipients', fn($r) => $r->where('recipient_id', Auth::id()));
        })->with(['sender', 'recipients'])->latest()->limit(50)->get()->reverse();

        return view('messages.conversation', compact('recipient', 'messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'content' => 'nullable|string|max:200',
            'image' => 'nullable|image|max:2048',
        ]);

        $recipient = User::findOrFail($request->recipient_id);

        if (!$recipient->isFollowedBy(Auth::user())) {
            return back()->with('error', 'No puedes enviar mensajes a este usuario.');
        }

        $path = $request->hasFile('image') 
            ? $request->file('image')->store('messages', 'public') 
            : null;

        $message = Message::create([
            'sender_id' => Auth::id(),
            'content' => $request->content,
            'image_path' => $path,
        ]);

        $message->recipients()->attach($recipient->id);

        Mail::to($recipient->email)->queue(new NewDirectMessage($message));

        return back();
    }

    public function forward($id)
    {
        $original = Message::with(['sender', 'recipients'])->findOrFail($id);
        $recipientId = request('recipient_id');

        $recipient = User::findOrFail($recipientId);
        if (!$recipient->isFollowedBy(Auth::user())) {
            return back()->with('error', 'No puedes reenviar a este usuario.');
        }

        $message = Message::create([
            'sender_id' => Auth::id(),
            'content' => $original->content,
            'image_path' => $original->image_path,
            'original_message_id' => $original->id,
        ]);

        $message->recipients()->attach($recipient->id);
        Mail::to($recipient->email)->queue(new NewDirectMessage($message));

        return back()->with('status', 'Mensaje reenviado.');
    }
}