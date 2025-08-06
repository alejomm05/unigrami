@extends('layouts.app')

@section('header')
    Iniciar Conversación
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Iniciar Conversación</h2>
        <p class="mb-4">Selecciona un usuario para comenzar una conversación:</p>

        @if ($users->isEmpty())
            <p>No hay usuarios disponibles para iniciar una conversación.</p>
        @else
            <ul>
                @foreach ($users as $user)
                    <li class="border-b border-gray-200 dark:border-gray-700 py-4">
                        <a href="{{ route('messages.conversation', $user->username) }}"
                           class="flex items-center space-x-3">
                            <img src="{{ asset('storage/' . $user->profile_image ?? 'images/default-avatar.png') }}"
                                 alt="{{ $user->username }}"
                                 class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <strong>{{ $user->username }}</strong>
                                <p class="text-sm text-gray-500">{{ $user->followers_count }} seguidores</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection