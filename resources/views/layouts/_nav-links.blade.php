{{-- Links de Navegación Principales --}}
<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300 hover:text-white">
        <i class="fa-solid fa-gauge-high mr-2"></i> {{ __('Dashboard') }}
    </x-nav-link>

    <x-nav-link :href="route('maquinarias.index')" :active="request()->routeIs('maquinarias.*')" class="text-gray-300 hover:text-white">
        <i class="fa-solid fa-truck-monster mr-2"></i> {{ __('Maquinaria') }}
    </x-nav-link>

    <x-nav-link :href="route('bitacora.index')" :active="request()->routeIs('bitacora.*')" class="text-gray-300 hover:text-white">
        <i class="fa-solid fa-book mr-2"></i> {{ __('Bitácora') }}
    </x-nav-link>

    {{-- Dropdown Catálogos --}}
    <div class="inline-flex items-center pt-1">
        <x-dropdown align="left" width="48">
            <x-slot name="trigger">
                <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-300 hover:text-white hover:border-gray-700 transition duration-150 ease-in-out focus:outline-none {{ request()->routeIs('catalogos.*') ? 'border-indigo-500 text-white' : '' }}">
                    <i class="fa-solid fa-folder-tree mr-2"></i> Catálogos
                    <svg class="ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>
            <x-slot name="content">
                <div class="bg-zinc-800 border border-zinc-700 shadow-xl">
                    <x-dropdown-link :href="route('catalogos.tipos.index')" class="text-gray-300 hover:bg-zinc-700"><i class="fa-solid fa-tags mr-2 w-4"></i> Tipos</x-dropdown-link>
                    <x-dropdown-link :href="route('catalogos.marcas.index')" class="text-gray-300 hover:bg-zinc-700"><i class="fa-solid fa-industry mr-2 w-4"></i> Marcas</x-dropdown-link>
                    <x-dropdown-link :href="route('catalogos.estatus.index')" class="text-gray-300 hover:bg-zinc-700"><i class="fa-solid fa-traffic-light mr-2 w-4"></i> Estatus</x-dropdown-link>
                    <x-dropdown-link :href="route('catalogos.ubicaciones.index')" class="text-gray-300 hover:bg-zinc-700"><i class="fa-solid fa-map-pin mr-2 w-4"></i> Ubicaciones</x-dropdown-link>
                    <x-dropdown-link :href="route('catalogos.frentes.index')" class="text-gray-300 hover:bg-zinc-700"><i class="fa-solid fa-helmet-safety mr-2 w-4"></i> Frentes</x-dropdown-link>
                </div>
            </x-slot>
        </x-dropdown>
    </div>

    <x-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')" class="text-gray-300 hover:text-white">
        <i class="fa-solid fa-users mr-2"></i> {{ __('Usuarios') }}
    </x-nav-link>
</div>

{{-- Menú de Usuario (Derecha) --}}
<div class="hidden sm:flex sm:items-center sm:ms-auto">
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-300 bg-zinc-800 hover:text-white hover:bg-zinc-700 focus:outline-none transition ease-in-out duration-150 border border-zinc-700">
                <i class="fa-solid fa-circle-user mr-2 text-indigo-400"></i>
                <div>{{ Auth::user()->name }}</div>
            </button>
        </x-slot>
        <x-slot name="content">
            <div class="bg-zinc-800 border border-zinc-700 shadow-xl">
                <x-dropdown-link :href="route('profile.edit')" class="text-gray-300 hover:bg-zinc-700">
                    <i class="fa-solid fa-user-gear mr-2 w-4"></i> {{ __('Perfil') }}
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" class="text-red-400 hover:bg-red-900/20" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fa-solid fa-power-off mr-2 w-4"></i> {{ __('Cerrar Sesión') }}
                    </x-dropdown-link>
                </form>
            </div>
        </x-slot>
    </x-dropdown>
</div>