@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">

  {{-- Cabecera del perfil --}}
  <div class="flex items-center space-x-8 mb-8">
    {{-- Foto de perfil --}}
    <div>
      <img
        src="{{ $user->profile_image
                  ? asset('storage/' . $user->profile_image)
                  : asset('images/default-avatar.png') }}"
        alt="Foto de perfil de {{ $user->username }}"
        class="w-32 h-32 rounded-full object-cover border border-gray-300"
      >
    </div>

    {{-- Datos del usuario --}}
    <div class="flex-1">
      <div class="flex items-center space-x-4 mb-4">
        <h2 class="text-2xl font-light">{{ $user->username }}</h2>

        {{-- Botón editar o seguir --}}
        @can('update', $user)
          <a href="{{ route('profile.edit') }}"
             class="px-4 py-1 border rounded text-sm font-semibold">
            Editar perfil
          </a>
        @else
          <livewire:follow-button :user="$user" />
        @endcan
      </div>

      {{-- Estadísticas --}}
      <div class="flex space-x-6 mb-4">
        <span><strong>{{ $postsCount }}</strong> publicaciones</span>
        <span><strong>{{ $followersCount }}</strong> seguidores</span>
        <span><strong>{{ $followingCount }}</strong> seguidos</span>
      </div>

     {{-- Biografía --}}
@if($user->bio || $user->display_name)
    <div class="mt-3 text-sm">
        @if($user->display_name)
            <p class="font-bold">{{ $user->display_name }}</p>
        @endif
        @if($user->bio)
            <p class="text-gray-700 leading-tight whitespace-pre-line">{{ $user->bio }}</p>
        @endif
    </div>
@endif
  </div>

  {{-- Grid de publicaciones --}}
  <div class="grid grid-cols-3 gap-4">
    @forelse($posts as $post)
      <a href="{{ route('posts.show', $post) }}">
        <img
          src="{{ asset('storage/' . $post->media_first) }}"
          alt="Publicación {{ $post->id }}"
          class="w-full h-48 object-cover hover:opacity-75 transition"
        >
      </a>
    @empty
      <p class="col-span-3 text-center text-gray-500">
        No hay publicaciones aún.
      </p>
    @endforelse
  </div>

</div>
@endsection
