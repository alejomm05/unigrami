@extends('layouts.app')

@section('header')
    Nueva Publicación
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Imagen -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Selecciona una imagen</label>
                <input type="file" name="image" id="image" accept="image/*" required
                       class="mt-1 block w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Leyenda -->
            <div class="mb-4">
                <label for="caption" class="block text-sm font-medium text-gray-700">Leyenda (máx. 200 caracteres)</label>
                <textarea name="caption" id="caption" rows="3" maxlength="200"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                          placeholder="Escribe una leyenda...">{{ old('caption') }}</textarea>
                @error('caption') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded font-medium">
                    Publicar
                </button>
            </div>
        </form>
    </div>
@endsection