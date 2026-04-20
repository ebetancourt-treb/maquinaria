@php
    $colors = [
        'uso'           => 'bg-blue-100 text-blue-800',
        'mantenimiento' => 'bg-amber-100 text-amber-800',
        'asignacion'    => 'bg-purple-100 text-purple-800',
        'incidencia'    => 'bg-red-100 text-red-800',
        'inspeccion'    => 'bg-green-100 text-green-800',
    ];
@endphp
<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$registro->tipo_evento] ?? 'bg-gray-100 text-gray-800' }}">
    <i class="fa-solid {{ $registro->icono_evento }} text-[10px]"></i>
    {{ $registro->etiqueta_evento }}

</span>
