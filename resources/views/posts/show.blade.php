@extends('layouts.app')

@section('header')
    Publicación
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 flex items-center">
                <img src="{{ asset('storage/' . $post->user->profile_image) }}" alt="{{ $post->user->username }}" class="w-10 h-10 rounded-full mr-3">
                <a href="{{ route('profile.show', $post->user->username) }}" class="font-bold">{{ $post->user->username }}</a>
            </div>
            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Publicación" class="w-full">
            @if($post->caption)
                <div class="p-4">
                    <p>
                        <strong>{{ $post->user->username }}</strong>
                        {!! preg_replace('/@([a-zA-Z0-9_]+)/', '<a href="/profile/$1" class="text-blue-500">@$1</a>', e($post->caption)) !!}
                    </p>
                </div>
            @endif
            <div class="px-4 py-2">
                <a href="#" class="text-sm text-gray-500">Ver comentarios ({{ $post->comments->count() }})</a>
            </div>
        </div>

        <!-- Comentarios -->
        <div class="mt-6">
            <h3 class="font-semibold mb-2">Comentarios</h3>
            @foreach($post->comments as $comment)
                <div class="flex mb-2">
                    <strong class="mr-2">{{ $comment->user->username }}:</strong>
                    <span>
                        {!! preg_replace('/@([a-zA-Z0-9_]+)/', '<a href="/profile/$1" class="text-blue-500">@$1</a>', e($comment->content)) !!}
                    </span>
                </div>
            @endforeach

            <form action="{{ route('comments.store') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div class="flex">
                    <input type="text" name="content" placeholder="Añade un comentario..." class="flex-1 border border-gray-300 rounded-l px-4 py-2" maxlength="200" required>
                    <button type="submit" class="bg-blue-500 text-white rounded-r px-4 py-2">
                        Comentar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection