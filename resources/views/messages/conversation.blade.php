@extends('layouts.app')

@section('header')
    Conversación con {{ $recipient->username }}
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        <div class="space-y-4 mb-6 h-96 overflow-y-auto">
            @foreach($messages as $msg)
                <div class="{{ $msg->sender_id === Auth::id() ? 'text-right' : 'text-left' }}">
                    <div class="inline-block max-w-xs px-4 py-2 rounded-lg bg-blue-500 text-white text-sm">
                        {{ $msg->content }}
                    </div>
                    @if($msg->image_path)
                        <div class="mt-1">
                            <img src="{{ asset('storage/' . $msg->image_path) }}" class="max-w-xs rounded">
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

       <form method="POST" action="{{ route('messages.send', $recipient->username) }}" enctype="multipart/form-data">
    @csrf
    <div class="flex space-x-2">
        <input type="text" name="content" placeholder="Escribe un mensaje..." class="flex-1 border border-gray-300 rounded px-3 py-2">
        <input type="file" name="image" accept="image/*" class="border border-gray-300 rounded text-sm">
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">
            Enviar
        </button>
    </div>
</form>
    </div>
@endsection