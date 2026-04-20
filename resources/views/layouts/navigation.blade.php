<nav x-data="{ open: false }" class="bg-zinc-900 border-b border-zinc-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- CAMBIO AQUÍ: justify-between asegura que los extremos se separen --}}
        <div class="flex justify-between h-16">
            
            {{-- Bloque Izquierdo: Logo + Links --}}
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-500" />
                    </a>
                </div>

                {{-- Solo los links de navegación van aquí --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300">
                        <i class="fa-solid fa-gauge-high mr-2"></i> {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('maquinarias.index')" :active="request()->routeIs('maquinarias.*')" class="text-gray-300">
                        <i class="fa-solid fa-truck-monster mr-2"></i> {{ __('Maquinaria') }}
                    </x-nav-link>

                    <x-nav-link :href="route('bitacora.index')" :active="request()->routeIs('bitacora.*')" class="text-gray-300">
                        <i class="fa-solid fa-book mr-2"></i> {{ __('Bitácora') }}
                    </x-nav-link>

                    {{-- Dropdown Catálogos --}}
                    <div class="inline-flex items-center pt-1">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-300 hover:text-white transition duration-150 ease-in-out focus:outline-none {{ request()->routeIs('catalogos.*') ? 'border-indigo-500 text-white' : '' }}">
                                    <i class="fa-solid fa-folder-tree mr-2"></i> Catálogos
                                    <svg class="ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                {{-- Contenido de catálogos --}}
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <x-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')" class="text-gray-300">
                        <i class="fa-solid fa-users mr-2"></i> {{ __('Usuarios') }}
                    </x-nav-link>
                </div>
            </div>

            {{-- Bloque Derecho: Dropdown de Usuario --}}
            {{-- ms-auto empuja este div hasta la derecha --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-300 bg-zinc-800 hover:text-white focus:outline-none transition ease-in-out duration-150 border border-zinc-700">
                            <i class="fa-solid fa-circle-user mr-2 text-indigo-400"></i>
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-currentColor h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- Perfil y Logout --}}
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="...">
                    {{-- SVG del menú --}}
                </button>
            </div>
        </div>
    </div>
</nav>