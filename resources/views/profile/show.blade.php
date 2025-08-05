@extends('layouts.app')

@section('header')
    Perfil de {{ $user->display_name }}
@endsection

@section('content')
    <div class="flex flex-col md:flex-row md:items-start space-y-6 md:space-y-0 md:space-x-8 mb-8">
        <div class="flex-shrink-0">
            <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-avatar.png') }}" alt="Foto de perfil" class="w-32 h-32 rounded-full object-cover border border-gray-300">
        </div>

        <div class="flex-1">
            <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-4">
                <h2 class="text-2xl font-bold">{{ $user->username }}</h2>
                @if(Auth::id() === $user->id)
                    <a href="{{ route('profile.edit') }}" class="px-4 py-1 border rounded text-sm font-semibold text-gray-700 hover:bg-gray-100">
                        Editar perfil
                    </a>
                @else
                    @livewire('follow-button', ['user' => $user])
                @endif
            </div>

            <div class="flex space-x-6 mb-4 text-sm">
                <span><strong>{{ $user->posts_count }}</strong> publicaciones</span>
                <span><strong>{{ $user->followers_count }}</strong> seguidores</span>
                <span><strong>{{ $user->follows_count }}</strong> siguiendo</span>
            </div>

            @if($user->bio || $user->display_name)
                <div class="text-sm leading-tight">
                    @if($user->display_name)
                        <p class="font-bold">{{ $user->display_name }}</p>
                    @endif
                    @if($user->bio)
                        <p class="text-gray-700 whitespace-pre-line">{{ $user->bio }}</p>
                    @endif
                    @if($user->website)
                        <p class="text-blue-500 hover:underline">
                            <a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a>
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4">
        @forelse($posts as $post)
            <a href="{{ route('posts.show', $post) }}" class="aspect-square">
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Publicación" class="w-full h-full object-cover hover:opacity-75 transition">
            </a>
        @empty
            <p class="col-span-3 text-center text-gray-500 py-8">No hay publicaciones aún.</p>
        @endforelse
    </div>
@endsection