@extends('layouts.app')

@section('header')
    Conversaciones
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        @if (count($formattedConversations) === 0)
            <p class="text-center text-gray-500">No tienes conversaciones.</p>
        @else
            <ul>
                @foreach ($formattedConversations as $conversation)
                    <li class="border-b border-gray-200 dark:border-gray-700 py-4">
                        <a href="{{ route('messages.conversation', $conversation['username']) }}"
                           class="flex items-center space-x-3">
                            <img src="{{ asset('storage/' . $conversation['avatar'] ?? 'images/default-avatar.png') }}"
                                 alt="{{ $conversation['username'] }}"
                                 class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <strong>{{ $conversation['username'] }}</strong>
                                <p class="text-sm text-gray-500">{{ $conversation['last_message']->content }}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection