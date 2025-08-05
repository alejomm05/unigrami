<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- metas, CSS, etc. -->
</head>
<body class="font-sans antialiased">

  <nav class="bg-white border-b border-gray-200 px-4 py-2 flex justify-between items-center">
    <!-- Logo / Nombre app -->
    <a href="{{ url('/') }}" class="text-lg font-semibold">Unigrami</a>

    <!-- Enlaces invitados -->
    <div class="space-x-4">
      <a href="{{ route('login') }}"
         class="text-gray-700 hover:text-gray-900">
        Login
      </a>

      @if (Route::has('register'))
        <a href="{{ route('register') }}"
           class="text-gray-700 hover:text-gray-900">
          Registro
        </a>
      @endif
    </div>
  </nav>

  <div class="min-h-screen bg-gray-100">
    {{ $slot }}
  </div>

  <!-- scripts -->
</body>
</html>
