<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-plus mr-2"></i>Nueva Maquinaria
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="POST" action="{{ route('maquinarias.store') }}">
                    @csrf
                    @include('maquinarias._form')

                    <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                        <a href="{{ route('maquinarias.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                            <i class="fa-solid fa-save mr-2"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new TomSelect('#tipo_id', { create: false, sortField: 'text' });
            new TomSelect('#marca_id', { create: false, sortField: 'text' });
            new TomSelect('#responsable_id', { create: false, sortField: 'text' });
            new TomSelect('#frente_id', { create: false, sortField: 'text' });
            new TomSelect('#estatus_id', { create: false, sortField: 'text' });
            new TomSelect('#ubicacion_id', { create: false, sortField: 'text' });
        });
    </script>
    @endpush
</x-app-layout>
