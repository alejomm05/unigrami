<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Unigrami') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

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
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/" wire:navigate>
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
