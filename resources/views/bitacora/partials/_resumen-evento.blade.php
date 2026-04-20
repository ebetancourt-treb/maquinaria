@switch($registro->tipo_evento)
    @case('uso')
        @if($registro->horas_uso)
            <span class="font-medium">{{ $registro->horas_uso }} hrs</span>
            ({{ $registro->horometro_anterior }} → {{ $registro->horometro_actual }})
        @endif
        @if($registro->kilometros_recorridos)
            <span class="font-medium">{{ $registro->kilometros_recorridos }} km</span>
            ({{ $registro->kilometraje_anterior }} → {{ $registro->kilometraje_actual }})
        @endif
        @break

    @case('mantenimiento')
        <span class="font-medium capitalize">{{ $registro->tipo_mantenimiento }}</span>
        — {{ Str::limit($registro->descripcion_trabajo, 60) }}
        @if($registro->costo)
            <span class="text-green-700 font-medium">${{ number_format($registro->costo, 2) }}</span>
        @endif
        @break

    @case('asignacion')
        {{ $registro->responsableAnterior?->name ?? 'Sin asignar' }}
        <i class="fa-solid fa-arrow-right mx-1 text-xs text-gray-400"></i>
        {{ $registro->responsableNuevo?->name ?? 'Sin asignar' }}
        @break

    @case('incidencia')
        <span class="font-medium capitalize">{{ str_replace('_', ' ', $registro->tipo_incidencia) }}</span>
        @if($registro->requiere_paro)
            <span class="ml-1 text-red-600 font-bold text-xs">⬤ PARO</span>
        @endif
        @break

    @case('inspeccion')
        Estado: <span class="font-medium capitalize">{{ $registro->estado_general }}</span>
        @if(!is_null($registro->aprobado))
            — {{ $registro->aprobado ? '✓ Aprobado' : '✗ No aprobado' }}
        @endif
        @break
@endswitch
