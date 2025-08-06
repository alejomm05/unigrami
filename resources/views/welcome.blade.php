<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Unigrami</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .leaf-icon {
            font-family: 'Figtree', sans-serif;
            font-size: 2rem;
            font-weight: 600;
            color: #FF8C42;
        }
        .leaf-icon span {
            color: #000;
        }

        /* Estilo para el fondo oscuro */
        .dark-bg {
            background-color: #222; /* Fondo oscuro */
            color: #fff; /* Texto blanco */
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-white">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Imagen de fondo con tema natural -->
        
        <div class="hidden md:flex md:w-1/2 dark-bg bg-cover bg-center bg-no-repeat" 
             style="background-image: url('https://images.unsplash.com/photo-1579546988645-0d9cbb7f41c9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80');">
            <div class="flex items-center justify-center w-full h-full bg-black bg-opacity-30">
                <div class="text-center text-white px-8">
                    <div class="leaf-icon mb-4">
                        unigrami <span>🍃</span>
                    </div>
                    <p class="text-lg">Bienvenido!</p>
                </div>
            </div>
        </div>

        <!-- Formulario de bienvenida -->
        <div class="flex-1 flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm p-8">
                <!-- Logo personalizado -->
                <div class="text-center mb-8">
                    <div class="leaf-icon text-3xl">
                        unigrami <span>🍂</span>
                    </div>
                    <p class="text-gray-600 text-sm mt-1">Comparte tu esencia</p>
                </div>

                <!-- Botones de acción -->
                <div class="space-y-4">
                    <a href="{{ route('login') }}" 
                       class="block w-full py-3 text-center bg-orange-500 hover:bg-orange-600 text-white font-semibold text-sm rounded transition duration-200">
                        Iniciar sesión
                    </a>
                    <a href="{{ route('register') }}" 
                       class="block w-full py-3 text-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-800 font-semibold text-sm rounded transition duration-200">
                        Registrarse
                    </a>
                </div>

                <!-- Separador -->
                <div class="my-6 flex items-center">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-4 text-sm text-gray-500">o</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                <!-- Mensaje de registro -->
                <p class="text-center text-sm text-gray-600">
                    ¿Nuevo en unigrami? 
                    <a href="{{ route('register') }}" 
                       class="text-orange-500 hover:underline font-medium">
                        Únete ahora
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html> 