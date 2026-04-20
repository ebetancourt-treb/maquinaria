<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="fa-solid fa-truck-monster mr-2"></i>Maquinaria
            </h2>
            <a href="{{ route('maquinarias.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                <i class="fa-solid fa-plus mr-2"></i> Nueva Máquina
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                    <i class="fa-solid fa-check-circle mr-1"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Filtros --}}
            <div class="bg-white shadow-sm rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('maquinarias.index') }}"
                      class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-7 gap-3 items-end">

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Buscar</label>
                        <input type="text" name="buscar" value="{{ request('buscar') }}"
                               placeholder="ID, serie, placas..."
                               class="w-full rounded-lg border-gray-300 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tipo</label>
                        <select name="tipo_id" class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="">Todos</option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}" @selected(request('tipo_id') == $tipo->id)>
                                    {{ $tipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Marca</label>
                        <select name="marca_id" class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="">Todas</option>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id }}" @selected(request('marca_id') == $marca->id)>
                                    {{ $marca->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Estatus</label>
                        <select name="estatus_id" class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="">Todos</option>
                            @foreach ($estatuses as $est)
                                <option value="{{ $est->id }}" @selected(request('estatus_id') == $est->id)>
                                    {{ $est->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Frente</label>
                        <select name="frente_id" class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="">Todos</option>
                            @foreach ($frentes as $frente)
                                <option value="{{ $frente->id }}" @selected(request('frente_id') == $frente->id)>
                                    {{ $frente->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Responsable</label>
                        <select name="responsable_id" class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="">Todos</option>
                            @foreach ($responsables as $user)
                                <option value="{{ $user->id }}" @selected(request('responsable_id') == $user->id)>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                                class="px-4 py-2 bg-gray-800 text-white text-sm rounded-lg hover:bg-gray-700 transition">
                            <i class="fa-solid fa-search"></i>
                        </button>
                        <a href="{{ route('maquinarias.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-600 text-sm rounded-lg hover:bg-gray-300 transition">
                            <i class="fa-solid fa-times"></i>
                        </a>
                    </div>
                </form>
            </div>

            {{-- Tabla --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Marca / Modelo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">N° Serie</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Responsable</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Frente</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($maquinarias as $maq)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 text-sm font-mono font-bold text-blue-700 whitespace-nowrap">
                                        <a href="{{ route('maquinarias.show', $maq) }}" class="hover:underline">
                                            {{ $maq->identificador }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ $maq->tipo->nombre }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 max-w-xs truncate">
                                        {{ $maq->descripcion }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ $maq->marca->nombre }}
                                        @if($maq->modelo)
                                            <span class="text-gray-400">/ {{ $maq->modelo }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-xs text-gray-500 font-mono whitespace-nowrap">
                                        {{ $maq->numero_serie ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">
                                        {{ $maq->responsable->name ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">
                                        {{ $maq->frente->nombre ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <x-badge :estatus="$maq->estatus" />
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap">
                                        <div class="flex items-center gap-2 justify-end">
                                            <a href="{{ route('maquinarias.bitacora', $maq) }}"
                                               class="text-gray-400 hover:text-blue-600 transition"
                                               title="Ver bitácora">
                                                <i class="fa-solid fa-book text-sm"></i>
                                            </a>
                                            <a href="{{ route('maquinarias.edit', $maq) }}"
                                               class="text-gray-400 hover:text-amber-600 transition"
                                               title="Editar">
                                                <i class="fa-solid fa-pen text-sm"></i>
                                            </a>
                                            <form method="POST" action="{{ route('maquinarias.destroy', $maq) }}"
                                                  class="inline"
                                                  onsubmit="return confirm('¿Eliminar {{ $maq->identificador }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        class="text-gray-400 hover:text-red-600 transition"
                                                        title="Eliminar">
                                                    <i class="fa-solid fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-8 text-center text-gray-400">
                                        <i class="fa-solid fa-truck-monster text-3xl mb-2 block"></i>
                                        No se encontraron equipos
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $maquinarias->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
