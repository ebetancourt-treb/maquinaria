{{-- Después de Dashboard --}}
<x-nav-link :href="route('maquinarias.index')" :active="request()->routeIs('maquinarias.*')">
    <i class="fa-solid fa-truck-monster mr-1"></i> {{ __('Maquinaria') }}
</x-nav-link>

<x-nav-link :href="route('bitacora.index')" :active="request()->routeIs('bitacora.*')">
    <i class="fa-solid fa-book mr-1"></i> {{ __('Bitácora') }}
</x-nav-link>

{{-- Dropdown de catálogos --}}
<x-dropdown align="left" width="48">
    <x-slot name="trigger">
        <button class="inline-flex items-center ...">
            <i class="fa-solid fa-folder-tree mr-1"></i> Catálogos
        </button>
    </x-slot>
    <x-slot name="content">
        <x-dropdown-link :href="route('catalogos.tipos.index')">Tipos</x-dropdown-link>
        <x-dropdown-link :href="route('catalogos.marcas.index')">Marcas</x-dropdown-link>
        <x-dropdown-link :href="route('catalogos.estatus.index')">Estatus</x-dropdown-link>
        <x-dropdown-link :href="route('catalogos.ubicaciones.index')">Ubicaciones</x-dropdown-link>
        <x-dropdown-link :href="route('catalogos.frentes.index')">Frentes</x-dropdown-link>
    </x-slot>
</x-dropdown>

<x-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')">
    <i class="fa-solid fa-users mr-1"></i> {{ __('Usuarios') }}
</x-nav-link>