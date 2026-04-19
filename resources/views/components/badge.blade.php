@props(['estatus'])

@if($estatus)
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $estatus->badge_class }}">
        {{ $estatus->nombre }}
    </span>
@else
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
        Sin estatus
    </span>
@endif