<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-truck-monster mr-2"></i>{{ $maquinaria->identificador }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $maquinaria->tipo->nombre }} — {{ $maquinaria->descripcion }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('maquinarias.bitacora', $maquinaria) }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    <i class="fa-solid fa-book mr-2"></i> Bitácora
                </a>
                <a href="{{ route('maquinarias.edit', $maquinaria) }}"
                   class="inline-flex items-center px-4 py-2 bg-amber-500 text-white text-sm font-medium rounded-lg hover:bg-amber-600 transition">
                    <i class="fa-solid fa-pen mr-2"></i> Editar
                </a>
                <a href="{{ route('maquinarias.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                    <i class="fa-solid fa-check-circle mr-1"></i> {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Ficha técnica --}}
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Ficha técnica</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Identificador</dt>
                                <dd class="text-sm font-bold text-blue-700 font-mono mt-0.5">{{ $maquinaria->identificador }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Tipo</dt>
                                <dd class="text-sm text-gray-800 mt-0.5">{{ $maquinaria->tipo->nombre }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">N° de serie</dt>
                                <dd class="text-sm text-gray-800 font-mono mt-0.5">{{ $maquinaria->numero_serie ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Marca / Modelo</dt>
                                <dd class="text-sm text-gray-800 mt-0.5">
                                    {{ $maquinaria->marca->nombre }}
                                    {{ $maquinaria->modelo ? '/ ' . $maquinaria->modelo : '' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Color</dt>
                                <dd class="text-sm text-gray-800 mt-0.5">{{ $maquinaria->color ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Placas</dt>
                                <dd class="text-sm text-gray-800 mt-0.5">{{ $maquinaria->placas ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Estatus</dt>
                                <dd class="mt-0.5"><x-badge :estatus="$maquinaria->estatus" /></dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Responsable</dt>
                                <dd class="text-sm text-gray-800 mt-0.5">{{ $maquinaria->responsable->name ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Frente laboral</dt>
                                <dd class="text-sm text-gray-800 mt-0.5">{{ $maquinaria->frente->nombre ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Ubicación</dt>
                                <dd class="text-sm text-gray-800 mt-0.5">{{ $maquinaria->ubicacion->nombre ?? '—' }}</dd>
                            </div>

                            @if($maquinaria->usaHorometro())
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Horómetro</dt>
                                <dd class="text-sm font-bold text-gray-800 mt-0.5">
                                    {{ number_format($maquinaria->horometro_actual, 1) }} hrs
                                </dd>
                            </div>
                            @endif

                            @if($maquinaria->usaKilometraje())
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Kilometraje</dt>
                                <dd class="text-sm font-bold text-gray-800 mt-0.5">
                                    {{ number_format($maquinaria->kilometraje_actual, 1) }} km
                                </dd>
                            </div>
                            @endif
                        </dl>

                        @if($maquinaria->notas)
                            <div class="mt-6 pt-4 border-t border-gray-100">
                                <dt class="text-xs font-medium text-gray-500 uppercase mb-1">Notas</dt>
                                <dd class="text-sm text-gray-600">{{ $maquinaria->notas }}</dd>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Panel lateral: últimos registros --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                            <i class="fa-solid fa-clock-rotate-left mr-1"></i> Últimos registros
                        </h3>
                        <a href="{{ route('maquinarias.bitacora', $maquinaria) }}"
                           class="text-xs text-blue-600 hover:underline">Ver todos</a>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse ($ultimosRegistros as $reg)
                            @php
                                $dotColors = [
                                    'uso' => 'bg-blue-500',
                                    'mantenimiento' => 'bg-amber-500',
                                    'asignacion' => 'bg-purple-500',
                                    'incidencia' => 'bg-red-500',
                                    'inspeccion' => 'bg-green-500',
                                ];
                            @endphp
                            <a href="{{ route('bitacora.show', $reg) }}"
                               class="block px-5 py-3 hover:bg-gray-50 transition">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full {{ $dotColors[$reg->tipo_evento] ?? 'bg-gray-400' }} flex-shrink-0"></div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-800 capitalize">{{ $reg->etiqueta_evento }}</p>
                                        <p class="text-xs text-gray-400">
                                            {{ $reg->fecha_evento->format('d/m/Y H:i') }}
                                            · {{ $reg->registrador->name ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="px-5 py-8 text-center text-gray-400 text-sm">
                                Sin registros aún
                            </div>
                        @endforelse
                    </div>

                    <div class="p-4 border-t border-gray-100">
                        <a href="{{ route('bitacora.create', ['maquinaria_id' => $maquinaria->id]) }}"
                           class="block w-full text-center px-4 py-2 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-100 transition">
                            <i class="fa-solid fa-plus mr-1"></i> Nuevo registro
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>