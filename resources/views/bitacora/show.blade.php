<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-book mr-2"></i>Registro #{{ $registro->id }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $registro->maquinaria->identificador }} — {{ $registro->etiqueta_evento }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('maquinarias.bitacora', $registro->maquinaria) }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                    <i class="fa-solid fa-timeline mr-2"></i> Timeline
                </a>
                <a href="{{ route('bitacora.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Bitácora
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">

                {{-- Header del registro --}}
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    @include('bitacora.partials._badge-evento', ['registro' => $registro])
                    <span class="text-sm text-gray-500">
                        {{ $registro->fecha_evento->format('d/m/Y H:i') }}
                        · {{ $registro->fecha_evento->diffForHumans() }}
                    </span>
                </div>

                <div class="p-6">
                    {{-- Info de la máquina --}}
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex items-center gap-4">
                            <div>
                                <p class="text-lg font-bold text-blue-700 font-mono">
                                    {{ $registro->maquinaria->identificador }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $registro->maquinaria->tipo->nombre }}
                                    — {{ $registro->maquinaria->marca->nombre ?? '' }}
                                    {{ $registro->maquinaria->modelo ?? '' }}
                                </p>
                            </div>
                            <a href="{{ route('maquinarias.show', $registro->maquinaria) }}"
                               class="ml-auto text-sm text-blue-600 hover:underline">
                                Ver ficha <i class="fa-solid fa-chevron-right ml-1"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Contenido según tipo de evento --}}
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">

                        @if($registro->tipo_evento === 'uso')
                            @if($registro->horometro_anterior !== null || $registro->horometro_actual !== null)
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Horómetro anterior</dt>
                                    <dd class="text-sm text-gray-800 mt-0.5">{{ $registro->horometro_anterior ?? '—' }} hrs</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Horómetro actual</dt>
                                    <dd class="text-sm font-bold text-gray-800 mt-0.5">{{ $registro->horometro_actual ?? '—' }} hrs</dd>
                                </div>
                                @if($registro->horas_uso)
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500 uppercase">Horas de uso</dt>
                                        <dd class="text-sm font-bold text-blue-700 mt-0.5">{{ $registro->horas_uso }} hrs</dd>
                                    </div>
                                @endif
                            @endif
                            @if($registro->kilometraje_anterior !== null || $registro->kilometraje_actual !== null)
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Km anterior</dt>
                                    <dd class="text-sm text-gray-800 mt-0.5">{{ $registro->kilometraje_anterior ?? '—' }} km</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Km actual</dt>
                                    <dd class="text-sm font-bold text-gray-800 mt-0.5">{{ $registro->kilometraje_actual ?? '—' }} km</dd>
                                </div>
                                @if($registro->kilometros_recorridos)
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500 uppercase">Km recorridos</dt>
                                        <dd class="text-sm font-bold text-blue-700 mt-0.5">{{ $registro->kilometros_recorridos }} km</dd>
                                    </div>
                                @endif
                            @endif
                        @endif

                        @if($registro->tipo_evento === 'mantenimiento')
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Tipo de mantenimiento</dt>
                                <dd class="text-sm text-gray-800 mt-0.5 capitalize">{{ $registro->tipo_mantenimiento }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Costo</dt>
                                <dd class="text-sm font-bold text-green-700 mt-0.5">
                                    {{ $registro->costo ? '$' . number_format($registro->costo, 2) : '—' }}
                                </dd>
                            </div>
                            <div class="md:col-span-2">
                                <dt class="text-xs font-medium text-gray-500 uppercase">Descripción del trabajo</dt>
                                <dd class="text-sm text-gray-800 mt-0.5">{{ $registro->descripcion_trabajo }}</dd>
                            </div>
                            @if($registro->proveedor)
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Proveedor</dt>
                                    <dd class="text-sm text-gray-800 mt-0.5">{{ $registro->proveedor }}</dd>
                                </div>
                            @endif
                            @if($registro->proximo_mantenimiento)
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Próximo mantenimiento</dt>
                                    <dd class="text-sm font-bold text-amber-700 mt-0.5">
                                        {{ $registro->proximo_mantenimiento->format('d/m/Y') }}
                                    </dd>
                                </div>
                            @endif
                        @endif

                        @if($registro->tipo_evento === 'asignacion')
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Responsable anterior</dt>
                                <dd class="text-sm text-gray-800 mt-0.5">
                                    {{ $registro->responsableAnterior->name ?? 'Sin asignar' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Nuevo responsable</dt>
                                <dd class="text-sm font-bold text-gray-800 mt-0.5">
                                    {{ $registro->responsableNuevo->name ?? 'Sin asignar' }}
                                </dd>
                            </div>
                            @if($registro->frenteAnterior || $registro->frenteNuevo)
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Frente anterior</dt>
                                    <dd class="text-sm text-gray-800 mt-0.5">
                                        {{ $registro->frenteAnterior->nombre ?? '—' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Nuevo frente</dt>
                                    <dd class="text-sm font-bold text-gray-800 mt-0.5">
                                        {{ $registro->frenteNuevo->nombre ?? '—' }}
                                    </dd>
                                </div>
                            @endif
                            @if($registro->motivo_asignacion)
                                <div class="md:col-span-2">
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Motivo</dt>
                                    <dd class="text-sm text-gray-800 mt-0.5">{{ $registro->motivo_asignacion }}</dd>
                                </div>
                            @endif
                        @endif

                        @if($registro->tipo_evento === 'incidencia')
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Tipo de incidencia</dt>
                                <dd class="text-sm text-gray-800 mt-0.5 capitalize">
                                    {{ str_replace('_', ' ', $registro->tipo_incidencia) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Severidad</dt>
                                <dd class="mt-0.5">
                                    @php
                                        $sevColor = match($registro->severidad) {
                                            'critica' => 'bg-red-100 text-red-800',
                                            'alta'    => 'bg-orange-100 text-orange-800',
                                            'media'   => 'bg-yellow-100 text-yellow-800',
                                            default   => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sevColor }}">
                                        {{ ucfirst($registro->severidad) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Requiere paro</dt>
                                <dd class="text-sm mt-0.5">
                                    @if($registro->requiere_paro)
                                        <span class="text-red-600 font-bold">Sí — equipo detenido</span>
                                    @else
                                        <span class="text-gray-600">No</span>
                                    @endif
                                </dd>
                            </div>
                            @if($registro->accion_tomada)
                                <div class="md:col-span-2">
                                    <dt class="text-xs font-medium text-gray-500 uppercase">Acción tomada</dt>
                                    <dd class="text-sm text-gray-800 mt-0.5">{{ $registro->accion_tomada }}</dd>
                                </div>
                            @endif
                        @endif

                        @if($registro->tipo_evento === 'inspeccion')
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Estado general</dt>
                                <dd class="mt-0.5">
                                    @php
                                        $estadoColor = match($registro->estado_general) {
                                            'bueno'   => 'bg-green-100 text-green-800',
                                            'regular' => 'bg-yellow-100 text-yellow-800',
                                            'malo'    => 'bg-red-100 text-red-800',
                                            default   => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $estadoColor }}">
                                        {{ ucfirst($registro->estado_general) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Aprobado</dt>
                                <dd class="text-sm mt-0.5">
                                    @if(is_null($registro->aprobado))
                                        <span class="text-gray-400">N/A</span>
                                    @elseif($registro->aprobado)
                                        <span class="text-green-600 font-bold"><i class="fa-solid fa-check mr-1"></i>Sí</span>
                                    @else
                                        <span class="text-red-600 font-bold"><i class="fa-solid fa-times mr-1"></i>No</span>
                                    @endif
                                </dd>
                            </div>
                        @endif

                        {{-- Campos comunes --}}
                        @if($registro->estatusResultante)
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Estatus resultante</dt>
                                <dd class="mt-0.5"><x-badge :estatus="$registro->estatusResultante" /></dd>
                            </div>
                        @endif
                    </dl>

                    @if($registro->observaciones)
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <dt class="text-xs font-medium text-gray-500 uppercase mb-1">Observaciones</dt>
                            <dd class="text-sm text-gray-700">{{ $registro->observaciones }}</dd>
                        </div>
                    @endif

                    {{-- Footer --}}
                    <div class="mt-6 pt-4 border-t border-gray-100 text-xs text-gray-400">
                        Registrado por <span class="font-medium text-gray-600">{{ $registro->registrador->name }}</span>
                        el {{ $registro->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
