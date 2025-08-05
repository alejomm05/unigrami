@extends('layouts.app')

@section('header')
    Feed
@endsection

@section('content')
    <!-- Historias destacadas -->
    <div class="bg-white p-4 rounded-lg shadow flex space-x-4 overflow-x-auto mb-6">
        @foreach ($stories as $user => $story)
            <a href="#" class="flex flex-col items-center">
                <div class="w-16 h-16 border-2 border-pink-500 rounded-full p-0.5">
                    <img src="{{ asset('storage/' . $story->first()->user->profile_image) }}" alt="{{ $user }}" class="w-full h-full rounded-full object-cover">
                </div>
                <span class="text-xs mt-1">{{ $user }}</span>
            </a>
        @endforeach
    </div>

    <!-- Botón flotante para crear publicación -->
<div class="fixed bottom-6 right-6">
    <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white rounded-full p-4 shadow-lg flex items-center justify-center w-12 h-12">
        ➕
    </a>
</div>

       <!-- Publicaciones -->
    @foreach ($posts as $post)
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="p-4 flex items-center">
                <img src="{{ asset('storage/' . $post->user->profile_image) }}" alt="{{ $post->user->username }}" class="w-10 h-10 rounded-full mr-3">
                <a href="{{ route('profile.show', $post->user->username) }}" class="font-bold text-sm">{{ $post->user->username }}</a>
            </div>
            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Publicación" class="w-full">
            @if($post->caption)
                <div class="p-4">
                    <p class="text-sm">
                        <strong>{{ $post->user->username }}</strong>
                        {!! preg_replace('/@([a-zA-Z0-9_]+)/', '<a href="/profile/$1" class="text-blue-500">@$1</a>', e($post->caption)) !!}
                    </p>
                </div>
            @endif
            <div class="px-4 py-2">
                <a href="{{ route('posts.show', $post) }}" class="text-sm text-gray-500">
                    Ver comentarios ({{ $post->comments->count() }})
                </a>
            </div>
        </div>
    @endforeach
    
    <!-- Sugerencias -->
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="font-bold mb-3">Sugerencias para ti</h3>
        @foreach ($suggestions as $suggestedUser)
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center">
                    <img src="{{ $suggestedUser->profile_image ? asset('storage/' . $suggestedUser->profile_image) : asset('images/default-avatar.png') }}" alt="{{ $suggestedUser->username }}" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <p class="font-semibold text-sm">{{ $suggestedUser->username }}</p>
                        <p class="text-xs text-gray-500">{{ $suggestedUser->followers_count }} seguidores</p>
                    </div>
                </div>
                <a href="{{ route('profile.show', $suggestedUser->username) }}" class="text-blue-500 text-xs">Ver perfil</a>
            </div>
        @endforeach
    </div>
@endsection