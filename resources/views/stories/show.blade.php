@extends('layouts.app')

@section('header')
    Historia de {{ $story->user->username }}
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        <!-- Encabezado -->
        <div class="flex items-center mb-4">
            <img src="{{ asset('storage/' . $story->user->profile_image) }}" alt="{{ $story->user->username }}" class="w-10 h-10 rounded-full mr-3">
            <a href="{{ route('profile.show', $story->user->username) }}" class="font-bold">{{ $story->user->username }}</a>
        </div>

        <!-- Imagen o video -->
        @if($story->type === 'photo')
            <img src="{{ asset('storage/' . $story->media_path) }}" alt="Historia" class="w-full">
        @elseif($story->type === 'video')
            <video controls class="w-full">
                <source src="{{ asset('storage/' . $story->media_path) }}" type="video/mp4">
                Tu navegador no soporta videos.
            </video>
        @endif

        <!-- Leyenda -->
        @if($story->caption)
            <div class="p-4">
                <p class="text-sm">
                    <strong>{{ $story->user->username }}</strong>
                    {!! preg_replace('/@([a-zA-Z0-9_]+)/', '<a href="/profile/$1" class="text-blue-500">@$1</a>', e($story->caption)) !!}
                </p>
            </div>
        @endif

        <!-- Reacciones y comentarios -->
        <div class="mt-6">
            <h3 class="font-semibold mb-2">Reacciones</h3>
            <!-- Implementar reacciones aquí -->
        </div>
    </div>
@endsection