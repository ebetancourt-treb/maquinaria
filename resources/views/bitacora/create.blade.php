<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-plus mr-2"></i>Nuevo Registro de Bitácora
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form method="POST" action="{{ route('bitacora.store') }}" x-data="{
                    tipoEvento: '{{ old('tipo_evento', $tipoEvento) }}',
                    maquinariaId: '{{ old('maquinaria_id', $maquinaria?->id) }}',
                    tipoMedicion: '{{ $maquinaria?->tipo?->tipo_medicion ?? 'ninguno' }}',
                }">
                    @csrf

                    {{-- Selector de máquina --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Máquina <span class="text-red-500">*</span>
                        </label>
                        <select name="maquinaria_id" id="maquinaria_id" required
                                class="w-full rounded-lg border-gray-300"
                                x-model="maquinariaId">
                            <option value="">Seleccionar máquina...</option>
                            @foreach ($maquinarias as $m)
                                <option value="{{ $m->id }}"
                                        data-medicion="{{ $m->tipo->tipo_medicion }}"
                                        @selected(old('maquinaria_id', $maquinaria?->id) == $m->id)>
                                    {{ $m->identificador }} — {{ $m->tipo->nombre }}
                                    ({{ $m->marca->nombre ?? '' }})
                                </option>
                            @endforeach
                        </select>
                        @error('maquinaria_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tabs de tipo de evento --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tipo de evento <span class="text-red-500">*</span>
                        </label>
                        <input type="hidden" name="tipo_evento" x-model="tipoEvento">
                        <div class="flex flex-wrap gap-2">
                            @foreach ([
                                'uso' => ['Uso diario', 'fa-clock', 'blue'],
                                'mantenimiento' => ['Mantenimiento', 'fa-wrench', 'amber'],
                                'asignacion' => ['Asignación', 'fa-people-arrows', 'purple'],
                                'incidencia' => ['Incidencia', 'fa-triangle-exclamation', 'red'],
                                'inspeccion' => ['Inspección', 'fa-clipboard-check', 'green'],
                            ] as $key => [$label, $icon, $color])
                                <button type="button"
                                        @click="tipoEvento = '{{ $key }}'"
                                        :class="tipoEvento === '{{ $key }}'
                                            ? 'bg-{{ $color }}-100 text-{{ $color }}-800 ring-2 ring-{{ $color }}-400'
                                            : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                                        class="px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
                                    <i class="fa-solid {{ $icon }}"></i> {{ $label }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Fecha --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Fecha y hora del evento <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" name="fecha_evento"
                               value="{{ old('fecha_evento', now()->format('Y-m-d\TH:i')) }}"
                               class="w-full md:w-1/2 rounded-lg border-gray-300" required>
                        @error('fecha_evento')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ═══ CAMPOS DE USO ═══ --}}
                    <div x-show="tipoEvento === 'uso'" x-cloak>
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-3 border-b pb-2">
                            <i class="fa-solid fa-clock mr-1"></i> Registro de uso
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6"
                             x-show="tipoMedicion === 'horometro' || tipoMedicion === 'ambos'">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Horómetro actual (hrs)
                                </label>
                                <input type="number" name="horometro_actual" step="0.01" min="0"
                                       value="{{ old('horometro_actual') }}"
                                       placeholder="{{ $maquinaria?->horometro_actual ?? '0' }}"
                                       class="w-full rounded-lg border-gray-300">
                                @if($maquinaria)
                                    <p class="text-xs text-gray-400 mt-1">
                                        Lectura anterior: {{ $maquinaria->horometro_actual }} hrs
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6"
                             x-show="tipoMedicion === 'kilometraje' || tipoMedicion === 'ambos'">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Kilometraje actual (km)
                                </label>
                                <input type="number" name="kilometraje_actual" step="0.01" min="0"
                                       value="{{ old('kilometraje_actual') }}"
                                       placeholder="{{ $maquinaria?->kilometraje_actual ?? '0' }}"
                                       class="w-full rounded-lg border-gray-300">
                                @if($maquinaria)
                                    <p class="text-xs text-gray-400 mt-1">
                                        Lectura anterior: {{ $maquinaria->kilometraje_actual }} km
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div x-show="tipoMedicion === 'ninguno'" class="text-sm text-gray-500 italic mb-4">
                            Este tipo de máquina no tiene medición de horómetro ni kilometraje.
                        </div>
                    </div>

                    {{-- ═══ CAMPOS DE MANTENIMIENTO ═══ --}}
                    <div x-show="tipoEvento === 'mantenimiento'" x-cloak>
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-3 border-b pb-2">
                            <i class="fa-solid fa-wrench mr-1"></i> Mantenimiento
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Tipo <span class="text-red-500">*</span>
                                </label>
                                <select name="tipo_mantenimiento" class="w-full rounded-lg border-gray-300">
                                    <option value="">Seleccionar...</option>
                                    <option value="preventivo" @selected(old('tipo_mantenimiento') === 'preventivo')>
                                        Preventivo
                                    </option>
                                    <option value="correctivo" @selected(old('tipo_mantenimiento') === 'correctivo')>
                                        Correctivo
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Costo</label>
                                <input type="number" name="costo" step="0.01" min="0"
                                       value="{{ old('costo') }}"
                                       placeholder="0.00"
                                       class="w-full rounded-lg border-gray-300">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Descripción del trabajo <span class="text-red-500">*</span>
                            </label>
                            <textarea name="descripcion_trabajo" rows="3"
                                      class="w-full rounded-lg border-gray-300"
                                      placeholder="Describe el trabajo realizado...">{{ old('descripcion_trabajo') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Proveedor</label>
                                <input type="text" name="proveedor"
                                       value="{{ old('proveedor') }}"
                                       class="w-full rounded-lg border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Próximo mantenimiento
                                </label>
                                <input type="date" name="proximo_mantenimiento"
                                       value="{{ old('proximo_mantenimiento') }}"
                                       class="w-full rounded-lg border-gray-300">
                            </div>
                        </div>
                    </div>

                    {{-- ═══ CAMPOS DE ASIGNACIÓN ═══ --}}
                    <div x-show="tipoEvento === 'asignacion'" x-cloak>
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-3 border-b pb-2">
                            <i class="fa-solid fa-people-arrows mr-1"></i> Asignación / Traspaso
                        </h3>

                        @if($maquinaria?->responsable)
                            <p class="text-sm text-gray-600 mb-3">
                                Responsable actual:
                                <span class="font-medium">{{ $maquinaria->responsable->name }}</span>
                            </p>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Nuevo responsable <span class="text-red-500">*</span>
                                </label>
                                <select name="responsable_nuevo_id" id="responsable_nuevo_id"
                                        class="w-full rounded-lg border-gray-300">
                                    <option value="">Seleccionar...</option>
                                    @foreach ($responsables as $user)
                                        <option value="{{ $user->id }}" @selected(old('responsable_nuevo_id') == $user->id)>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Nuevo frente laboral
                                </label>
                                <select name="frente_nuevo_id" id="frente_nuevo_id"
                                        class="w-full rounded-lg border-gray-300">
                                    <option value="">Sin cambio</option>
                                    @foreach ($frentes as $frente)
                                        <option value="{{ $frente->id }}" @selected(old('frente_nuevo_id') == $frente->id)>
                                            {{ $frente->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Motivo</label>
                            <input type="text" name="motivo_asignacion"
                                   value="{{ old('motivo_asignacion') }}"
                                   placeholder="Ej: Cambio de frente, rotación de personal..."
                                   class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>

                    {{-- ═══ CAMPOS DE INCIDENCIA ═══ --}}
                    <div x-show="tipoEvento === 'incidencia'" x-cloak>
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-3 border-b pb-2">
                            <i class="fa-solid fa-triangle-exclamation mr-1"></i> Incidencia
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Tipo de incidencia <span class="text-red-500">*</span>
                                </label>
                                <select name="tipo_incidencia" class="w-full rounded-lg border-gray-300">
                                    <option value="">Seleccionar...</option>
                                    @foreach ([
                                        'falla_mecanica' => 'Falla mecánica',
                                        'falla_electrica' => 'Falla eléctrica',
                                        'accidente' => 'Accidente',
                                        'robo' => 'Robo',
                                        'vandalismo' => 'Vandalismo',
                                        'desgaste' => 'Desgaste',
                                    ] as $val => $label)
                                        <option value="{{ $val }}" @selected(old('tipo_incidencia') === $val)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Severidad <span class="text-red-500">*</span>
                                </label>
                                <select name="severidad" class="w-full rounded-lg border-gray-300">
                                    <option value="">Seleccionar...</option>
                                    @foreach (['baja','media','alta','critica'] as $sev)
                                        <option value="{{ $sev }}" @selected(old('severidad') === $sev)>
                                            {{ ucfirst($sev) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Acción tomada</label>
                            <textarea name="accion_tomada" rows="3"
                                      class="w-full rounded-lg border-gray-300"
                                      placeholder="Describe las acciones realizadas...">{{ old('accion_tomada') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="requiere_paro" value="1"
                                       class="rounded border-gray-300 text-red-600 focus:ring-red-500"
                                       @checked(old('requiere_paro'))>
                                <span class="ml-2 text-sm text-gray-700 font-medium">
                                    Requiere paro del equipo
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- ═══ CAMPOS DE INSPECCIÓN ═══ --}}
                    <div x-show="tipoEvento === 'inspeccion'" x-cloak>
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-3 border-b pb-2">
                            <i class="fa-solid fa-clipboard-check mr-1"></i> Inspección
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Estado general <span class="text-red-500">*</span>
                                </label>
                                <select name="estado_general" class="w-full rounded-lg border-gray-300">
                                    <option value="">Seleccionar...</option>
                                    @foreach (['bueno' => 'Bueno', 'regular' => 'Regular', 'malo' => 'Malo'] as $val => $label)
                                        <option value="{{ $val }}" @selected(old('estado_general') === $val)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Aprobado</label>
                                <select name="aprobado" class="w-full rounded-lg border-gray-300">
                                    <option value="">N/A</option>
                                    <option value="1" @selected(old('aprobado') === '1')>Sí</option>
                                    <option value="0" @selected(old('aprobado') === '0')>No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- ═══ CAMPOS COMUNES ═══ --}}
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Cambiar estatus del equipo
                            </label>
                            <select name="estatus_resultante_id" class="w-full md:w-1/2 rounded-lg border-gray-300">
                                <option value="">Sin cambio de estatus</option>
                                @foreach ($estatuses as $est)
                                    <option value="{{ $est->id }}" @selected(old('estatus_resultante_id') == $est->id)>
                                        {{ $est->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-400 mt-1">
                                Opcional: si este evento cambia el estatus de la máquina.
                            </p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Observaciones
                            </label>
                            <textarea name="observaciones" rows="3"
                                      class="w-full rounded-lg border-gray-300"
                                      placeholder="Notas adicionales...">{{ old('observaciones') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ $maquinaria
                                    ? route('maquinarias.bitacora', $maquinaria)
                                    : route('bitacora.index') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                                <i class="fa-solid fa-save mr-2"></i> Guardar Registro
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const maqSelect = new TomSelect('#maquinaria_id', {
                create: false,
                sortField: 'text',
                placeholder: 'Buscar máquina...',
                onChange: function(value) {
                    // Actualizar tipo_medicion según la máquina seleccionada
                    const option = this.options[value];
                    if (option) {
                        const el = document.querySelector(`#maquinaria_id option[value="${value}"]`);
                        const medicion = el?.dataset?.medicion || 'ninguno';
                        // Actualizar Alpine
                        document.querySelector('[x-data]').__x.$data.tipoMedicion = medicion;
                        document.querySelector('[x-data]').__x.$data.maquinariaId = value;
                    }
                }
            });

            new TomSelect('#responsable_nuevo_id', {
                create: false, sortField: 'text',
                placeholder: 'Buscar responsable...',
            });

            new TomSelect('#frente_nuevo_id', {
                create: false, sortField: 'text',
                placeholder: 'Buscar frente...',
            });
        });
    </script>
    @endpush
</x-app-layout>
