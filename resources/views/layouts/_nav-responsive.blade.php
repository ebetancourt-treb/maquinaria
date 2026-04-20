{{-- 
    INSTRUCCIÓN: Copia el contenido de este archivo dentro del 
    <!-- Responsive Navigation Menu --> de tu navigation.blade.php de Breeze.
--}}
<div class="pt-2 pb-3 space-y-1">
    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
    <x-responsive-nav-link :href="route('maquinarias.index')" :active="request()->routeIs('maquinarias.*')">Maquinaria</x-responsive-nav-link>
    <x-responsive-nav-link :href="route('bitacora.index')" :active="request()->routeIs('bitacora.*')">Bitácora</x-responsive-nav-link>
    <x-responsive-nav-link :href="route('catalogos.tipos.index')" :active="request()->routeIs('catalogos.*')">Catálogos</x-responsive-nav-link>
    <x-responsive-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')">Usuarios</x-responsive-nav-link>
</div>
