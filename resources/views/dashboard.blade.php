@extends('layouts.app')

@section('header')
  <h2 class="text-2xl font-light text-black">
    Feed
  </h2>
@endsection

@section('content')
  {{-- Historias destacadas --}}
  <section class="flex space-x-4 overflow-x-auto mb-8 px-4">
    @foreach ($stories as $userId => $userStories)
      @php $user = $userStories->first()->user @endphp
      <a href="#" class="flex flex-col items-center">
        <div class="w-16 h-16 rounded-full border-4 border-autumn p-0.5">
          <img
            src="{{ asset('storage/' . $user->profile_image) }}"
            alt="{{ $user->username }}"
            class="w-full h-full rounded-full object-cover"
          >
        </div>
        <span class="mt-1 text-xs text-black">{{ $user->username }}</span>
      </a>
    @endforeach
  </section>

  {{-- Listado de publicaciones --}}
  <div class="space-y-6 px-4">
    @foreach ($posts as $post)
      <article class="bg-white rounded-xl shadow-sm overflow-hidden">
        <header class="flex items-center p-4 space-x-3">
          <img
            src="{{ asset('storage/' . $post->user->profile_image) }}"
            alt="{{ $post->user->username }}"
            class="w-10 h-10 rounded-full object-cover"
          >
          <a
            href="{{ route('profile.show', $post->user->username) }}"
            class="text-sm font-medium text-black hover:text-autumn transition"
          >
            {{ $post->user->username }}
          </a>
        </header>

        <img
          src="{{ asset('storage/' . $post->image_path) }}"
          alt="Publicación"
          class="w-full object-cover"
        >

        @if ($post->caption)
          <div class="p-4 border-t border-gray-200">
            <p class="text-sm text-black leading-relaxed">
              <span class="font-semibold">{{ $post->user->username }}</span>
              {!! preg_replace(
                    '/@([a-zA-Z0-9_]+)/',
                    '<a href="/profile/$1" class="text-autumn hover:underline">@$1</a>',
                    e($post->caption)
                  ) !!}
            </p>
          </div>
        @endif

        <footer class="flex justify-end px-4 py-2 border-t border-gray-100">
          <a
            href="{{ route('posts.show', $post) }}"
            class="text-xs text-black hover:text-autumn transition"
          >
            Ver comentarios ({{ $post->comments->count() }})
          </a>
        </footer>
      </article>
    @endforeach
  </div>



  {{-- Sugerencias --}}
  <section class="mt-8 bg-white rounded-lg shadow px-4 py-6 mx-4">
    <h3 class="text-lg font-medium text-black mb-4">Sugerencias para ti</h3>

    @foreach ($suggestions as $user)
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center space-x-3">
          <img
            src="{{ $user->profile_image
                  ? asset('storage/' . $user->profile_image)
                  : asset('images/default-avatar.png') }}"
            alt="{{ $user->username }}"
            class="w-10 h-10 rounded-full object-cover"
          >
          <div>
            <p class="text-sm font-medium text-black">{{ $user->username }}</p>
            <p class="text-xs text-gray-500">{{ $user->followers_count }} seguidores</p>
          </div>
        </div>
        <a
          href="{{ route('profile.show', $user->username) }}"
          class="text-xs text-autumn hover:underline transition"
        >
          Ver perfil
        </a>
      </div>
    @endforeach
  </section>
@endsection
