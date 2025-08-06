<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        <aside class="w-64 bg-white border-r border-gray-200">
            <livewire:welcome.navigation />
        </aside>

        <!-- Sección principal -->
        <main class="flex-1 w-full max-w-3xl mx-auto mt-4 px-4">
           @hasSection('header')
    <header class="bg-white shadow-sm rounded-lg p-4 mb-6">
        <h1 class="text-xl font-semibold text-gray-800">
            @yield('header')
        </h1>
    </header>
@endif

@yield('content')

        </main>
    </div>
</body>
</html>