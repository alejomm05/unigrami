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
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">
    <div class="min-h-screen flex">
        <!-- Barra lateral -->
        <aside class="w-64 bg-white border-r border-gray-200">
            <livewire:layout.navigation />
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