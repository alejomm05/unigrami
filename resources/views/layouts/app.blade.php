<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Unigrami</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js CDN -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .logo-text {
            font-family: 'Figtree', sans-serif;
            font-weight: 600;
            color: #FF8C42;
        }
        .dark .logo-text { @apply text-orange-400; }
        .dark { background-color: #121212; color: #e0e0e0; }
        .dark .bg-white { @apply bg-gray-900; }
        .dark .text-gray-900 { @apply text-gray-100; }
        .dark .text-gray-700 { @apply text-gray-300; }
        .dark .border-gray-200 { @apply border-gray-700; }
        .dark .hover\:bg-gray-100:hover { @apply hover:bg-gray-800; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 transition-colors duration-300">
    <div class="min-h-screen flex">
        <!-- Barra lateral -->
        <aside class="w-64 bg-white border-r border-gray-200 dark:bg-gray-900 dark:border-gray-700">
            <livewire:welcome.navigation />
        </aside>

        <!-- Sección principal -->
        <main class="flex-1 w-full max-w-3xl mx-auto mt-4 px-4">
           @hasSection('header')
            <header class="bg-white shadow-sm rounded-lg p-4 mb-6 dark:bg-gray-800">
                <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                    @yield('header')
                </h1>
            </header>
           @endif

           @yield('content')
        </main>
    </div>

    <!-- Botón flotante de mensajes -->
    <div x-data="chatWidget()" class="fixed bottom-6 right-6 z-50">
        <!-- Icono flotante -->
        <button @click="open = !open" class="bg-orange-500 hover:bg-orange-600 text-white rounded-full p-3 shadow-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.507 15.488 3 14.063 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
        </button>

        <!-- Panel de conversaciones -->
        <div x-show="open" @click.away="open = false" class="absolute bottom-16 right-0 w-80 bg-white rounded-lg shadow-xl border border-gray-200 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
            <div class="p-4 bg-orange-500 text-white font-semibold">
                Mensajes Directos
            </div>
            <div class="max-h-96 overflow-y-auto">
                @if($possibleRecipients->isEmpty())
                    <p class="p-4 text-sm text-gray-500">No hay usuarios que te sigan para chatear.</p>
                @else
                    <template x-for="user in users" :key="user.id">
                        <a :href="`/messages/${user.username}`" class="flex items-center space-x-3 p-4 hover:bg-gray-100 dark:hover:bg-gray-700 transition border-b border-gray-100 dark:border-gray-700">
                            <img :src="`/storage/${user.profile_image || 'images/default-avatar.png'}`" 
                                 alt="Foto de perfil" 
                                 class="w-10 h-10 rounded-full object-cover">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate" x-text="user.username"></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">Haga clic para chatear</p>
                            </div>
                        </a>
                    </template>
                @endif
            </div>
        </div>
    </div>

    <!-- Script de Alpine.js -->
    <script>
        function chatWidget() {
            return {
                open: false,
                users: @json($possibleRecipients->map(fn($u) => ['id' => $u->id, 'username' => $u->username, 'profile_image' => $u->profile_image]))
            }
        }
    </script>
</body>
</html>