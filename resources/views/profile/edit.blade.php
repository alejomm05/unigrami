{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Editar Perfil
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST"
                      action="{{ route('profile.update') }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    {{-- Nombre a mostrar --}}
                    <div class="mb-4">
                        <x-input-label for="display_name" :value="__('Nombre a mostrar')" />
                        <x-input id="display_name"
                                 class="block mt-1 w-full"
                                 type="text"
                                 name="display_name"
                                 :value="old('display_name', $user->display_name)"
                                 required />
                        <x-input-error :messages="$errors->get('display_name')"
                                       class="mt-2" />
                    </div>

                    {{-- Nombre de usuario --}}
                    <div class="mb-4">
                        <x-input-label for="username" :value="__('Nombre de usuario')" />
                        <x-input id="username"
                                 class="block mt-1 w-full"
                                 type="text"
                                 name="username"
                                 :value="old('username', $user->username)"
                                 required />
                        <x-input-error :messages="$errors->get('username')"
                                       class="mt-2" />
                    </div>

                    {{-- Sitio web --}}
                    <div class="mb-4">
                        <x-input-label for="website" :value="__('Sitio web')" />
                        <x-input id="website"
                                 class="block mt-1 w-full"
                                 type="url"
                                 name="website"
                                 :value="old('website', $user->website)" />
                        <x-input-error :messages="$errors->get('website')"
                                       class="mt-2" />
                    </div>

                  <!-- Biografía -->
   {{-- Biografía --}}
      @if($user->bio)
        <div class="text-sm">
          <p class="font-semibold">{{ $user->display_name }}</p>
          <p>{{ $user->bio }}</p>
        </div>
      @endif
    </div>
  </div>


                    {{-- Correo electrónico --}}
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Correo electrónico')" />
                        <x-input id="email"
                                 class="block mt-1 w-full"
                                 type="email"
                                 name="email"
                                 :value="old('email', $user->email)"
                                 required />
                        <x-input-error :messages="$errors->get('email')"
                                       class="mt-2" />
                    </div>

                    {{-- Foto de perfil --}}
                    <div class="mb-4">
                        <x-input-label for="profile_image" :value="__('Foto de perfil')" />
                        <x-input id="profile_image"
                                 class="block mt-1 w-full"
                                 type="file"
                                 name="profile_image"
                                 accept="image/*" />
                        <x-input-error :messages="$errors->get('profile_image')"
                                       class="mt-2" />

                        @if ($user->profile_image)
                            <p class="mt-2 text-sm text-gray-600">
                                Imagen actual:
                            </p>
                            <div class="mt-2">
                                <img src="{{ asset($user->profile_image) }}"
                                     alt="Foto actual"
                                     class="w-16 h-16 rounded-full object-cover">
                            </div>
                        @endif
                    </div>

                    {{-- Botones --}}
                    <div class="flex items-center justify-end space-x-2 mt-4">
                        <a href="{{ url()->previous() }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                            Cancelar
                        </a>
                        <x-primary-button>
                            Guardar cambios
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
