@extends('layouts.app')

@section('header')
    Editar Perfil
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="mb-4">
                <label for="display_name" class="block text-sm font-medium text-gray-700">Nombre a mostrar</label>
                <input id="display_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="text" name="display_name" value="{{ old('display_name', $user->display_name) }}" required>
                @error('display_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Nombre de usuario</label>
                <div class="flex items-center mt-1">
                    <span class="text-gray-500 mr-2">@</span>
                    <input id="username" class="block w-full border-gray-300 rounded-md shadow-sm" type="text" name="username" value="{{ old('username', $user->username) }}" required>
                </div>
                @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                <input id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="bio" class="block text-sm font-medium text-gray-700">Biografía</label>
                <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('bio', $user->bio) }}</textarea>
                <p class="text-gray-500 text-xs mt-1">Máximo 150 caracteres.</p>
                @error('bio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="website" class="block text-sm font-medium text-gray-700">Sitio web</label>
                <input id="website" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" type="url" name="website" value="{{ old('website', $user->website) }}" placeholder="https://tusitio.com">
                @error('website') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="profile_image" class="block text-sm font-medium text-gray-700">Foto de perfil</label>
                <input id="profile_image" class="mt-1 block w-full" type="file" name="profile_image" accept="image/*">
                <p class="text-gray-500 text-xs mt-1">JPG, PNG o GIF. Máx. 2MB.</p>
                @error('profile_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                @if ($user->profile_image)
                    <div class="mt-2">
                        <p class="text-sm text-gray-600">Foto actual:</p>
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Foto actual" class="mt-1 w-16 h-16 rounded-full object-cover border">
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-end space-x-4 mt-6">
                <a href="{{ route('profile.show', $user->username) }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded text-sm font-medium">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded text-sm font-medium">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
@endsection