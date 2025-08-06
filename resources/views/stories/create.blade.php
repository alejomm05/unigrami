@extends('layouts.app')

@section('header')
    Nueva Historia
@endsection

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 px-4 py-12 transition-colors duration-300">
        <div class="max-w-lg w-full bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 transition">
            <!-- Encabezado -->
            <div class="bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 p-6 text-center">
                <h1 class="text-2xl font-bold text-orange-600 dark:text-orange-300 flex items-center justify-center gap-2">
                    🍂 unigrami
                </h1>
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                    Comparte tu momento
                </p>
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('stories.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- Archivo multimedia -->
                <div>
                    <label for="media" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Foto o video (≤15 segundos)
                    </label>
                    <input
                        type="file"
                        name="media"
                        id="media"
                        accept="image/*,video/*"
                        required
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 dark:file:bg-orange-200 dark:file:text-orange-800"
                    >
                    @error('media')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Texto opcional -->
                <div>
                    <label for="caption" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        Texto o emojis (opcional)
                    </label>
                    <textarea
                        name="caption"
                        id="caption"
                        rows="3"
                        maxlength="200"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 sm:text-sm transition"
                        placeholder="Escribe algo...">{{ old('caption') }}</textarea>
                    @error('caption')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end space-x-4 pt-4">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 transition">
                        Cancelar
                    </a>
                    <button
                        type="submit"
                        class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium rounded-md shadow transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
                    >
                        Publicar Historia
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection