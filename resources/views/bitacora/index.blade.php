<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fa-solid fa-book mr-2"></i>Bitácora General
            </h2>
            <a href="{{ route('bitacora.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                <i class="fa-solid fa-plus mr-2"></i> Nuevo Registro
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filtros --}}
            <div class="bg-white shadow-sm rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('bitacora.index') }}"
                      class="grid grid-cols-1 md:grid-cols-5 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de evento</label>
                        <select name="tipo_evento" class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="">Todos</option>
                            @foreach (['uso','mantenimiento','asignacion','incidencia','inspeccion'] as $tipo)
                                <option value="{{ $tipo }}" @selected(request('tipo_evento') === $tipo)>
                                    {{ ucfirst($tipo) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Máquina</label>
                        <select name="maquinaria_id" id="filtro_maquinaria"
                                class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="">Todas</option>
                            @foreach ($maquinarias as $m)
                                <option value="{{ $m->id }}" @selected(request('maquinaria_id') == $m->id)>
                                    {{ $m->identificador }} — {{ $m->tipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                        <input type="date" name="desde" value="{{ request('desde') }}"
                               class="w-full rounded-lg border-gray-300 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                        <input type="date" name="hasta" value="{{ request('hasta') }}"
                               class="w-full rounded-lg border-gray-300 text-sm">
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit"
                                class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-700 transition">
                            <i class="fa-solid fa-search mr-1"></i> Filtrar
                        </button>
                        <a href="{{ route('bitacora.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300 transition">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            {{-- Tabla de registros --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Evento</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Máquina</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Detalle</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registró</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($registros as $reg)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">
                                    {{ $reg->fecha_evento->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @include('bitacora.partials._badge-evento', ['registro' => $reg])
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <a href="{{ route('maquinarias.bitacora', $reg->maquinaria) }}"
                                       class="text-blue-600 hover:underline font-medium">
                                        {{ $reg->maquinaria->identificador }}
                                    </a>
                                    <span class="text-gray-400 text-xs block">
                                        {{ $reg->maquinaria->tipo->nombre }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 max-w-xs truncate">
                                    @include('bitacora.partials._resumen-evento', ['registro' => $reg])
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $reg->registrador->name }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('bitacora.show', $reg) }}"
                                       class="text-blue-600 hover:text-blue-800 text-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                                    <i class="fa-solid fa-book-open text-3xl mb-2 block"></i>
                                    Sin registros en bitácora
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $registros->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new TomSelect('#filtro_maquinaria', {
                create: false, sortField: 'text',
                placeholder: 'Buscar máquina...',
            });
        });
    </script>
    @endpush
</x-app-layout>