{{-- Incluir este partial en maquinarias/index.blade.php --}}
<div x-data="{ open: false }">
    <button @click="open = true"
            class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
        <i class="fa-solid fa-file-import mr-2"></i> Importar Excel
    </button>

    {{-- Modal --}}
    <div x-show="open" x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         @keydown.escape.window="open = false">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="open = false"></div>
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full relative z-10 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fa-solid fa-file-import mr-2 text-green-600"></i>Importar Maquinaria
                </h3>

                <form method="POST" action="{{ route('maquinarias.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Archivo Excel (.xlsx, .xls, .csv)
                        </label>
                        <input type="file" name="archivo" accept=".xlsx,.xls,.csv" required
                               class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0 file:text-sm file:font-medium
                                      file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mb-4 text-xs text-amber-700">
                        <p class="font-medium mb-1">Columnas esperadas:</p>
                        <p>Tipo, N° Serie, ID, Descripción, Color, Marca, Modelo, Placas, Responsable, Frente, Estatus, Ubicación</p>
                        <p class="mt-1">Los catálogos nuevos se crean automáticamente.</p>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="open = false"
                                class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300 transition">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                            <i class="fa-solid fa-upload mr-1"></i> Importar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
