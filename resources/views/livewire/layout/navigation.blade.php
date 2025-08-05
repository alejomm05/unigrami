<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

  <!-- Contenedor principal -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">

      <!-- Sección izquierda: logo + enlaces -->
      <div class="flex">
        <div class="shrink-0 flex items-center">
          <a href="{{ route('welcome') }}">
            <x-application-logo class="block h-10 w-auto" />
          </a>
        </div>

        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
          <!-- Invitados -->
          @guest
            <x-responsive-nav-link
                :href="route('login')"
                :active="request()->routeIs('login')">
              {{ __('Login') }}
            </x-responsive-nav-link>

            @if (Route::has('register'))
              <x-responsive-nav-link
                  :href="route('register')"
                  :active="request()->routeIs('register')">
                {{ __('Registro') }}
              </x-responsive-nav-link>
            @endif

          <!-- Autenticados -->
          @else
            <x-responsive-nav-link
                :href="route('dashboard')"
                :active="request()->routeIs('dashboard')">
              {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('profile.show', auth()->user()->username)"
                :active="request()->routeIs('profile.show')">
              {{ __('Mi Perfil') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('profile.edit')"
                :active="request()->routeIs('profile.edit')">
              {{ __('Editar Perfil') }}
            </x-responsive-nav-link>
          @endguest
        </div>
      </div>

      <!-- Sección derecha: dropdown y hamburgesa -->
      <div class="hidden sm:flex sm:items-center sm:ml-6">
        @auth
          <x-dropdown align="right" width="48">
            <x-slot name="trigger">
              <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                <div>{{ Auth::user()->username }}</div>
                <div class="ml-1">
                  <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                    <path d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"/>
                  </svg>
                </div>
              </button>
            </x-slot>

            <x-slot name="content">
              <x-dropdown-link
                  :href="route('profile.show', auth()->user()->username)">
                {{ __('Mi Perfil') }}
              </x-dropdown-link>

              <x-dropdown-link
                  :href="route('profile.edit')">
                {{ __('Editar Perfil') }}
              </x-dropdown-link>

              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link
                    :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                  {{ __('Cerrar Sesión') }}
                </x-dropdown-link>
              </form>
            </x-slot>
          </x-dropdown>
        @endauth
      </div>

      <!-- Botón hamburguesa para mobile -->
      <div class="-mr-2 flex items-center sm:hidden">
        <button @click="open = ! open"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'inline-flex': ! open}"
                  class="inline-flex"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
            <path :class="{'hidden': ! open, 'inline-flex': open}"
                  class="hidden"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Menú responsivo -->
  <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
      @guest
        <x-responsive-nav-link
            :href="route('login')"
            :active="request()->routeIs('login')">
          {{ __('Login') }}
        </x-responsive-nav-link>

        @if (Route::has('register'))
          <x-responsive-nav-link
              :href="route('register')"
              :active="request()->routeIs('register')">
            {{ __('Registro') }}
          </x-responsive-nav-link>
        @endif

      @else
        <x-responsive-nav-link
            :href="route('dashboard')"
            :active="request()->routeIs('dashboard')">
          {{ __('Dashboard') }}
        </x-responsive-nav-link>

        <x-responsive-nav-link
            :href="route('profile.show', auth()->user()->username)"
            :active="request()->routeIs('profile.show')">
          {{ __('Mi Perfil') }}
        </x-responsive-nav-link>

        <x-responsive-nav-link
            :href="route('profile.edit')"
            :active="request()->routeIs('profile.edit')">
          {{ __('Editar Perfil') }}
        </x-responsive-nav-link>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <x-responsive-nav-link
              :href="route('logout')"
              onclick="event.preventDefault(); this.closest('form').submit();">
            {{ __('Cerrar Sesión') }}
          </x-responsive-nav-link>
        </form>
      @endguest
    </div>
  </div>
</nav>
