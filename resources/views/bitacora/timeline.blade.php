<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-timeline mr-2"></i>
                    Bitácora: {{ $maquinaria->identificador }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $maquinaria->tipo->nombre }} — {{ $maquinaria->marca->nombre }}
                    {{ $maquinaria->modelo }}
                    @if($maquinaria->numero_serie)
                        | S/N: {{ $maquinaria->numero_serie }}
                    @endif
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('bitacora.create', ['maquinaria_id' => $maquinaria->id]) }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    <i class="fa-solid fa-plus mr-2"></i> Nuevo Registro
                </a>
                <a href="{{ route('maquinarias.show', $maquinaria) }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Cards de resumen del equipo --}}
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6">
                {{-- Lecturas actuales --}}
                @if($maquinaria->usaHorometro())
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-xs text-gray-500 uppercase">Horómetro</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ number_format($maquinaria->horometro_actual, 1) }}
                    </p>
                    <p class="text-xs text-gray-400">horas</p>
                </div>
                @endif

                @if($maquinaria->usaKilometraje())
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-xs text-gray-500 uppercase">Kilometraje</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ number_format($maquinaria->kilometraje_actual, 1) }}
                    </p>
                    <p class="text-xs text-gray-400">km</p>
                </div>
                @endif

                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-xs text-gray-500 uppercase">Estatus</p>
                    <x-badge :estatus="$maquinaria->estatus" />
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-xs text-gray-500 uppercase">Registros</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_registros'] }}</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-xs text-gray-500 uppercase">Costo Mant.</p>
                    <p class="text-2xl font-bold text-gray-800">
                        ${{ number_format($stats['costo_mantenimiento'], 0) }}
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4">
                    <p class="text-xs text-gray-500 uppercase">Próx. Mant.</p>
                    <p class="text-sm font-bold {{ $stats['proximo_mantenimiento'] && $stats['proximo_mantenimiento'] <= now()->addDays(3) ? 'text-red-600' : 'text-gray-800' }}">
                        {{ $stats['proximo_mantenimiento']
                            ? \Carbon\Carbon::parse($stats['proximo_mantenimiento'])->format('d/m/Y')
                            : '—' }}
                    </p>
                </div>
            </div>

            {{-- Filtros rápidos por tipo --}}
            <div class="flex gap-2 mb-4 flex-wrap">
                <a href="{{ route('maquinarias.bitacora', $maquinaria) }}"
                   class="px-3 py-1.5 rounded-full text-xs font-medium transition
                   {{ !request('tipo_evento') ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Todos
                </a>
                @foreach (['uso','mantenimiento','asignacion','incidencia','inspeccion'] as $tipo)
                    <a href="{{ route('maquinarias.bitacora', [$maquinaria, 'tipo_evento' => $tipo]) }}"
                       class="px-3 py-1.5 rounded-full text-xs font-medium transition
                       {{ request('tipo_evento') === $tipo ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ ucfirst($tipo) }}
                    </a>
                @endforeach
            </div>

            {{-- Timeline --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="relative">
                    {{-- Línea vertical --}}
                    <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                    @forelse ($registros as $reg)
                        @php
                            $colorMap = [
                                'uso'           => 'bg-blue-500',
                                'mantenimiento' => 'bg-amber-500',
                                'asignacion'    => 'bg-purple-500',
                                'incidencia'    => 'bg-red-500',
                                'inspeccion'    => 'bg-green-500',
                            ];
                        @endphp
                        <div class="relative pl-12 pb-8 last:pb-0">
                            {{-- Dot --}}
                            <div class="absolute left-2.5 top-1 w-3 h-3 rounded-full {{ $colorMap[$reg->tipo_evento] ?? 'bg-gray-400' }} ring-2 ring-white"></div>

                            {{-- Contenido --}}
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        @include('bitacora.partials._badge-evento', ['registro' => $reg])
                                        <span class="text-xs text-gray-400 ml-2">
                                            {{ $reg->fecha_evento->format('d/m/Y H:i') }}
                                            · {{ $reg->fecha_evento->diffForHumans() }}
                                        </span>
                                    </div>
                                    <a href="{{ route('bitacora.show', $reg) }}"
                                       class="text-blue-600 hover:text-blue-800 text-xs">
                                        Ver detalle <i class="fa-solid fa-chevron-right ml-1"></i>
                                    </a>
                                </div>

                                <div class="text-sm text-gray-700">
                                    @include('bitacora.partials._resumen-evento', ['registro' => $reg])
                                </div>

                                @if($reg->observaciones)
                                    <p class="text-xs text-gray-500 mt-2 italic">
                                        {{ Str::limit($reg->observaciones, 120) }}
                                    </p>
                                @endif

                                <p class="text-xs text-gray-400 mt-2">
                                    Registrado por {{ $reg->registrador->name }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="pl-12 text-center text-gray-400 py-8">
                            <i class="fa-solid fa-timeline text-3xl mb-2 block"></i>
                            Sin registros en bitácora para este equipo
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $registros->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>