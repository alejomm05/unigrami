<aside class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-200 shadow-sm dark:bg-gray-900 dark:border-gray-700 hidden sm:flex flex-col"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', dropdownOpen: false }"
      @dark-mode.window="darkMode = $event.detail; localStorage.setItem('darkMode', darkMode)"
      x-init="$watch('darkMode', value => $dispatch('dark-mode', value))">

    <!-- Logo -->
    <div class="flex items-center justify-center h-16 border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-orange-500 dark:text-orange-400">
            unigrami <span class="text-black dark:text-white text-lg">🍂</span>
        </a>
    </div>

    <!-- Menú principal -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800 rounded-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-sm font-medium">Inicio</span>
        </a>

        <a href="{{ route('search') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800 rounded-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <span class="text-sm font-medium">Buscar</span>
        </a>

        <a href="{{ route('stories.create') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800 rounded-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span class="text-sm font-medium">Crear historia</span>
        </a>

        <a href="{{ route('messages.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800 rounded-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.507 15.488 3 14.063 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <span class="text-sm font-medium">Mensajes</span>
        </a>

        <a href="{{ route('notifications.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800 rounded-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM11 19H7a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2h-4l-3 3z" />
            </svg>
            <span class="text-sm font-medium">Notificaciones</span>
        </a>

        <a href="{{ route('posts.create') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800 rounded-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="text-sm font-medium">Publicar</span>
        </a>
    </nav>

    <!-- Usuario autenticado -->
    <div class="px-4 py-4 border-t border-gray-200 dark:border-gray-700">
        @auth
            <div class="relative">
                <!-- Botón de perfil -->
                <button @click="dropdownOpen = !dropdownOpen" class="w-full flex items-center space-x-3 px-2 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800 rounded-lg transition">
                    <img
                        src="{{ Auth::user()->profile_image
                                  ? asset('storage/' . Auth::user()->profile_image)
                                  : asset('images/default-avatar.png') }}"
                        alt="Tu perfil"
                        class="w-10 h-10 rounded-full border border-gray-300"
                    >
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">
                            {{ Auth::user()->username }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Tu cuenta</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Menú desplegable -->
                <div
                    x-show="dropdownOpen"
                    @click.away="dropdownOpen = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute bottom-full left-0 mb-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden z-50"
                >
                    <div class="py-1">
                        <a href="{{ route('profile.show', Auth::user()->username) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Ver perfil
                        </a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Editar perfil
                        </a>

                        <!-- Modo oscuro -->
                        <button
                            @click="darkMode = !darkMode"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                        >
                            <span x-text="darkMode ? 'Modo claro' : 'Modo oscuro'"></span>
                        </button>

                        <!-- Cerrar sesión -->
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="space-y-2">
                <a href="{{ route('login') }}" class="block text-center py-2 text-sm text-gray-700 hover:text-orange-500 font-medium">
                    Iniciar sesión
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="block text-center py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm rounded-md">
                        Registrarse
                    </a>
                @endif
            </div>
        @endauth
    </div>
</aside>