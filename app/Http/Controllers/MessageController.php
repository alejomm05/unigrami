<?php

// app/Http/Controllers/MessageController.php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewDirectMessage;
use App\Mail\MessageReceived;
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

    // Preparar datos para la vista
    $formattedConversations = [];
    foreach ($conversations as $key => $messages) {
        $lastMessage = $messages->last();
        $participant = $lastMessage->sender_id === Auth::id() 
            ? $messages->first()->recipients->first() 
            : $lastMessage->sender;

        $formattedConversations[] = [
            'username' => $participant->username,
            'avatar' => $participant->profile_image,
            'last_message' => $lastMessage,
        ];
    }

    return view('messages.index', compact('formattedConversations'));
}
    public function conversation($username)
    {
         $recipient = User::where('username', $username)->firstOrFail();
        
       // Validar que el destinatario siga al emisor
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

    public function send(Request $request, $username)
{
    $request->validate([
        'content' => 'nullable|string|max:200',
        'image' => 'nullable|image|max:2048',
    ]);

    $recipient = User::where('username', $username)->firstOrFail();

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

public function startConversation()
{
    $users = User::whereDoesntHave('followers', fn($query) => $query->where('follower_id', Auth::id()))
        ->orWhereHas('followers', fn($query) => $query->where('follower_id', Auth::id()))
        ->withCount('followers')
        ->orderByDesc('followers_count')
        ->limit(10)
        ->get();

    return view('messages.start', compact('users'));
}
    public function forward(Request $request, Message $message)
{
    $request->validate(['to_username' => 'required|exists:users,username']);

    $to = User::where('username', $request->to_username)->first();

    if (!$to->canReceiveFrom(Auth::user())) {
        return back()->with('error', 'Este usuario no puede recibir mensajes.');
    }

    $newMessage = Message::create([
        'sender_id' => Auth::id(),
        'content' => $message->content,
        'image_path' => $message->image_path,
    ]);

    $newMessage->recipients()->attach($to->id);

    Mail::to($to->email)->send(new MessageReceived($newMessage, Auth::user()));

    return back();
}
}