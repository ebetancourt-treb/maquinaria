<div class="pt-2 pb-3 space-y-1 bg-zinc-900">
    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300">
        <i class="fa-solid fa-gauge-high mr-2"></i> {{ __('Dashboard') }}
    </x-responsive-nav-link>
    
    <x-responsive-nav-link :href="route('maquinarias.index')" :active="request()->routeIs('maquinarias.*')" class="text-gray-300">
        <i class="fa-solid fa-truck-monster mr-2"></i> {{ __('Maquinaria') }}
    </x-responsive-nav-link>

    {{-- Sección Usuarios Móvil --}}
    <x-responsive-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')" class="text-gray-300 border-t border-zinc-800">
        <i class="fa-solid fa-users mr-2"></i> {{ __('Usuarios') }}
    </x-responsive-nav-link>
</div>

{{-- Opciones de Usuario Móvil --}}
<div class="pt-4 pb-1 border-t border-zinc-800 bg-zinc-900">
    <div class="px-4 flex items-center">
        <div class="flex-shrink-0">
            <i class="fa-solid fa-circle-user text-3xl text-indigo-400"></i>
        </div>
        <div class="ms-3">
            <div class="font-medium text-base text-gray-200">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
        </div>
    </div>

    <div class="mt-3 space-y-1">
        <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-400">
            <i class="fa-solid fa-user-gear mr-2"></i> {{ __('Perfil') }}
        </x-responsive-nav-link>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')" class="text-red-400" onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="fa-solid fa-power-off mr-2"></i> {{ __('Cerrar Sesión') }}
            </x-responsive-nav-link>
        </form>
    </div>
</div>