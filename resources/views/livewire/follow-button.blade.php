<div>
    {{-- Solo muestro el botón si el perfil no es mío --}}
    @if (Auth::id() !== $user->id)
        <button
            wire:click="toggleFollow"
            class="px-4 py-1 text-sm font-semibold rounded"
            :class="$isFollowing ? 'bg-gray-200 text-gray-800' : 'bg-blue-500 text-white'"
        >
            {{ $isFollowing ? 'Siguiendo' : 'Seguir' }}
        </button>
    @endif
</div>