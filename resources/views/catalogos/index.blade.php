<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"><i class="fa-solid fa-folder-tree mr-2"></i>{{ $titulo }}</h2>
            <a href="{{ route("{$routePrefix}.create") }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition"><i class="fa-solid fa-plus mr-2"></i> Nuevo</a>
        </div>
    </x-slot>
    <div class="py-6"><div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm"><i class="fa-solid fa-check-circle mr-1"></i> {{ session('success') }}</div>
        @endif
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50"><tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-4 py-3"></th>
                </tr></thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($items as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $item->id }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800 font-medium">{{ $item->nombre }}</td>
                            <td class="px-4 py-3">
                                @if($item->activo ?? true)
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Activo</span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="{{ route("{$routePrefix}.edit", $item) }}" class="text-gray-400 hover:text-amber-600"><i class="fa-solid fa-pen text-sm"></i></a>
                                    <form method="POST" action="{{ route("{$routePrefix}.destroy", $item) }}" class="inline" onsubmit="return confirm('¿Eliminar {{ $item->nombre }}?')">@csrf @method('DELETE')<button type="submit" class="text-gray-400 hover:text-red-600"><i class="fa-solid fa-trash text-sm"></i></button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400 text-sm">Sin registros</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-4 py-3 border-t border-gray-200">{{ $items->links() }}</div>
        </div>
    </div></div>
</x-app-layout>
