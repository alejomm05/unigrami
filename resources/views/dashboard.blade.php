@extends('layouts.app')

@section('content')
<div class="flex flex-col space-y-4">

    <!-- Historias -->
    <div class="mb-4">
        <h2 class="text-xl font-bold mb-2">Historias</h2>
        <div class="flex space-x-2 overflow-x-scroll no-scrollbar">
            @foreach ($stories as $story)
                <div
                    class="w-20 h-20 bg-cover bg-center rounded-full"
                    style="background-image: url('{{ asset($story->media_path) }}')">
                </div>
            @endforeach
        </div>
    </div>

    <!-- Feed de publicaciones -->
    <div>
        <h2 class="text-xl font-bold mb-2">Publicaciones</h2>

        @foreach ($posts as $post)
            <div class="p-4 bg-white shadow mb-4">
                <div class="flex items-center">
                    <img
                        src="{{ $post->user->profile_image }}"
                        alt="{{ $post->user->display_name }}"
                        class="w-10 h-10 rounded-full mr-2">

                    <span class="font-bold">{{ $post->user->display_name }}</span>
                </div>

                <img
                    src="{{ asset($post->image_path) }}"
                    alt="{{ $post->caption }}"
                    class="w-full mt-2">

                <div class="mt-2">
                    <p>{{ $post->caption }}</p>

                    <div class="flex space-x-2 mt-2">
                        <button
                            wire:click="likePost({{ $post->id }})"
                            class="text-gray-500 hover:text-gray-700">
                            <!-- ícono Me gusta -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path d="M2 10.5a2 2 0 012-2h7a2 2 0 110 4H4a2 2 0 01-2-2zm8 8a2 2 0 012 2h7a2 2 0 110-4h-1a1 1 0 00-1 1v3a1 1 0 01-1 1H8a1 1 0 01-1-1v-3a1 1 0 00-1-1z" />
                            </svg>
                        </button>

                        <button class="text-gray-500 hover:text-gray-700">
                            <!-- ícono Comentarios -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path d="M2 10.5a2 2 0 012-2h7a2 2 0 110 4H4a2 2 0 01-2-2zm8 8a2 2 0 012 2h7a2 2 0 110-4h-1a1 1 0 00-1 1v3a1 1 0 01-1 1H8a1 1 0 01-1-1v-3a1 1 0 00-1-1z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection
