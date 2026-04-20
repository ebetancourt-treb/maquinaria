<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-gauge-high mr-2"></i>{{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ═══ KPIs INVENTARIO ═══ --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                {{-- Total Equipos --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Equipos</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalEquipos }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-truck-monster text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- Disponibles --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Disponibles</p>
                            <p class="text-3xl font-bold text-green-700 mt-1">{{ $disponibles }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-circle-check text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- En Obra --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-amber-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">En Obra</p>
                            <p class="text-3xl font-bold text-amber-700 mt-1">{{ $enObra }}</p>
                        </div>
                        <div class="w-12 h-12 bg-amber-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-helmet-safety text-amber-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- No Funcionales --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">No Funcionales</p>
                            <p class="text-3xl font-bold text-red-700 mt-1">{{ $noFuncionales }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ KPIs BITÁCORA ═══ --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <p class="text-xs font-medium text-gray-500 uppercase">Registros hoy</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $registrosHoy }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <p class="text-xs font-medium text-gray-500 uppercase">Esta semana</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $registrosSemana }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <p class="text-xs font-medium text-gray-500 uppercase">Incidencias abiertas</p>
                    <p class="text-2xl font-bold {{ $incidenciasAbiertas > 0 ? 'text-red-600' : 'text-gray-800' }} mt-1">
                        {{ $incidenciasAbiertas }}
                    </p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <p class="text-xs font-medium text-gray-500 uppercase">Mant. próximos (7d)</p>
                    <p class="text-2xl font-bold {{ $mantenimientosProximos > 0 ? 'text-amber-600' : 'text-gray-800' }} mt-1">
                        {{ $mantenimientosProximos }}
                    </p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <p class="text-xs font-medium text-gray-500 uppercase">Costo mant. (30d)</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">
                        ${{ number_format($costoMantenimiento30d, 0) }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- ═══ ALERTAS DE MANTENIMIENTO ═══ --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                            <i class="fa-solid fa-bell text-amber-500 mr-2"></i>Próximos mantenimientos
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse ($alertasMantenimiento as $alerta)
                            <a href="{{ route('maquinarias.bitacora', $alerta->maquinaria) }}"
                               class="block px-5 py-3 hover:bg-gray-50 transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">
                                            {{ $alerta->maquinaria->identificador }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $alerta->maquinaria->tipo->nombre ?? '' }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $dias = now()->diffInDays($alerta->proximo_mantenimiento, false);
                                        @endphp
                                        <p class="text-sm font-bold {{ $dias <= 2 ? 'text-red-600' : 'text-amber-600' }}">
                                            {{ $alerta->proximo_mantenimiento->format('d/m/Y') }}
                                        </p>
                                        <p class="text-xs {{ $dias <= 2 ? 'text-red-500' : 'text-gray-400' }}">
                                            {{ $dias <= 0 ? 'Vencido' : "en {$dias} día(s)" }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="px-5 py-8 text-center text-gray-400 text-sm">
                                <i class="fa-solid fa-check-circle text-green-400 text-2xl mb-2 block"></i>
                                Sin mantenimientos próximos
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- ═══ ÚLTIMOS REGISTROS BITÁCORA ═══ --}}
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                            <i class="fa-solid fa-clock-rotate-left text-blue-500 mr-2"></i>Últimos registros
                        </h3>
                        <a href="{{ route('bitacora.index') }}"
                           class="text-xs text-blue-600 hover:underline">
                            Ver todos <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse ($ultimosRegistros as $reg)
                            <a href="{{ route('bitacora.show', $reg) }}"
                               class="block px-5 py-3 hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    @php
                                        $dotColors = [
                                            'uso' => 'bg-blue-500',
                                            'mantenimiento' => 'bg-amber-500',
                                            'asignacion' => 'bg-purple-500',
                                            'incidencia' => 'bg-red-500',
                                            'inspeccion' => 'bg-green-500',
                                        ];
                                    @endphp
                                    <div class="w-2.5 h-2.5 rounded-full {{ $dotColors[$reg->tipo_evento] ?? 'bg-gray-400' }} flex-shrink-0"></div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-medium text-gray-800">
                                                {{ $reg->maquinaria->identificador }}
                                            </span>
                                            <span class="text-xs text-gray-400">
                                                {{ $reg->maquinaria->tipo->nombre ?? '' }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 capitalize">
                                            {{ $reg->etiqueta_evento }}
                                            · {{ $reg->registrador->name ?? '' }}
                                        </p>
                                    </div>
                                    <span class="text-xs text-gray-400 flex-shrink-0">
                                        {{ $reg->fecha_evento->diffForHumans() }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="px-5 py-8 text-center text-gray-400 text-sm">
                                <i class="fa-solid fa-book-open text-2xl mb-2 block"></i>
                                Sin registros aún
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- ═══ DISTRIBUCIÓN POR TIPO ═══ --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                            <i class="fa-solid fa-chart-bar text-blue-500 mr-2"></i>Equipos por tipo
                        </h3>
                    </div>
                    <div class="p-5 space-y-3">
                        @foreach ($porTipo as $tipo)
                            @php
                                $pct = $totalEquipos > 0
                                    ? round($tipo->maquinarias_count / $totalEquipos * 100)
                                    : 0;
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-700">{{ $tipo->nombre }}</span>
                                    <span class="text-sm font-semibold text-gray-800">
                                        {{ $tipo->maquinarias_count }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full transition-all"
                                         style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ═══ DISTRIBUCIÓN POR FRENTE ═══ --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                            <i class="fa-solid fa-location-dot text-green-500 mr-2"></i>Equipos por frente laboral
                        </h3>
                    </div>
                    <div class="p-5 space-y-3">
                        @foreach ($porFrente as $frente)
                            @php
                                $pct = $totalEquipos > 0
                                    ? round($frente->maquinarias_count / $totalEquipos * 100)
                                    : 0;
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-700">{{ $frente->nombre }}</span>
                                    <span class="text-sm font-semibold text-gray-800">
                                        {{ $frente->maquinarias_count }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full transition-all"
                                         style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ═══ ALERTAS CALIDAD DE DATOS ═══ --}}
            @if($sinPlacas > 0 || $sinUbicacion > 0 || $sinResponsable > 0)
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
                    <h3 class="text-sm font-semibold text-amber-800 mb-3">
                        <i class="fa-solid fa-database mr-2"></i>Calidad de datos — atención requerida
                    </h3>
                    <div class="flex flex-wrap gap-4 text-sm">
                        @if($sinPlacas > 0)
                            <span class="text-amber-700">
                                <i class="fa-solid fa-id-card mr-1"></i>
                                <strong>{{ $sinPlacas }}</strong> sin placas
                            </span>
                        @endif
                        @if($sinUbicacion > 0)
                            <span class="text-amber-700">
                                <i class="fa-solid fa-map-pin mr-1"></i>
                                <strong>{{ $sinUbicacion }}</strong> sin ubicación
                            </span>
                        @endif
                        @if($sinResponsable > 0)
                            <span class="text-amber-700">
                                <i class="fa-solid fa-user-slash mr-1"></i>
                                <strong>{{ $sinResponsable }}</strong> sin responsable
                            </span>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
