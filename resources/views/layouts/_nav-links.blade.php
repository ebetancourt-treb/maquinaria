<x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
    <i class="fa-solid fa-gauge-high mr-2"></i> {{ __('Dashboard') }}
</x-nav-link>

<x-nav-link :href="route('maquinarias.index')" :active="request()->routeIs('maquinarias.*')">
    <i class="fa-solid fa-truck-monster mr-2"></i> {{ __('Maquinaria') }}
</x-nav-link>

<x-nav-link :href="route('bitacora.index')" :active="request()->routeIs('bitacora.*')">
    <i class="fa-solid fa-book mr-2"></i> {{ __('Bitácora') }}
</x-nav-link>

{{-- Dropdown Catálogos --}}
<div class="inline-flex items-center pt-1">
    <x-dropdown align="left" width="48">
        <x-slot name="trigger">
            <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out focus:outline-none {{ request()->routeIs('catalogos.*') ? 'border-indigo-400 text-gray-900' : '' }}">
                <i class="fa-solid fa-folder-tree mr-2"></i> Catálogos
                <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </x-slot>
        <x-slot name="content">
            <x-dropdown-link :href="route('catalogos.tipos.index')"><i class="fa-solid fa-tags mr-2 w-4"></i> Tipos</x-dropdown-link>
            <x-dropdown-link :href="route('catalogos.marcas.index')"><i class="fa-solid fa-industry mr-2 w-4"></i> Marcas</x-dropdown-link>
            <x-dropdown-link :href="route('catalogos.estatus.index')"><i class="fa-solid fa-traffic-light mr-2 w-4"></i> Estatus</x-dropdown-link>
            <x-dropdown-link :href="route('catalogos.ubicaciones.index')"><i class="fa-solid fa-map-pin mr-2 w-4"></i> Ubicaciones</x-dropdown-link>
            <x-dropdown-link :href="route('catalogos.frentes.index')"><i class="fa-solid fa-helmet-safety mr-2 w-4"></i> Frentes</x-dropdown-link>
        </x-slot>
    </x-dropdown>
</div>

<x-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')">
    <i class="fa-solid fa-users mr-2"></i> {{ __('Usuarios') }}
</x-nav-link>