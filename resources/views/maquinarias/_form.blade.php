{{-- Partial reutilizable para create y edit --}}
@php
    $maq = $maquinaria ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Tipo --}}
    <div>
        <label for="tipo_id" class="block text-sm font-medium text-gray-700 mb-1">
            Tipo <span class="text-red-500">*</span>
        </label>
        <select name="tipo_id" id="tipo_id" class="w-full rounded-lg border-gray-300" required>
            <option value="">Seleccionar tipo...</option>
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo->id }}" @selected(old('tipo_id', $maq?->tipo_id) == $tipo->id)>
                    {{ $tipo->nombre }} ({{ $tipo->prefijo_id }})
                </option>
            @endforeach
        </select>
        @error('tipo_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Identificador --}}
    <div>
        <label for="identificador" class="block text-sm font-medium text-gray-700 mb-1">
            Identificador
        </label>
        <input type="text" name="identificador" id="identificador"
               value="{{ old('identificador', $maq?->identificador) }}"
               placeholder="Se genera automáticamente si se deja vacío"
               class="w-full rounded-lg border-gray-300">
        @error('identificador') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Descripción --}}
    <div class="md:col-span-2">
        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">
            Descripción <span class="text-red-500">*</span>
        </label>
        <input type="text" name="descripcion" id="descripcion"
               value="{{ old('descripcion', $maq?->descripcion) }}"
               class="w-full rounded-lg border-gray-300" required>
        @error('descripcion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Número de serie --}}
    <div>
        <label for="numero_serie" class="block text-sm font-medium text-gray-700 mb-1">
            Número de serie
        </label>
        <input type="text" name="numero_serie" id="numero_serie"
               value="{{ old('numero_serie', $maq?->numero_serie) }}"
               class="w-full rounded-lg border-gray-300">
    </div>

    {{-- Marca --}}
    <div>
        <label for="marca_id" class="block text-sm font-medium text-gray-700 mb-1">
            Marca <span class="text-red-500">*</span>
        </label>
        <select name="marca_id" id="marca_id" class="w-full rounded-lg border-gray-300" required>
            <option value="">Seleccionar marca...</option>
            @foreach ($marcas as $marca)
                <option value="{{ $marca->id }}" @selected(old('marca_id', $maq?->marca_id) == $marca->id)>
                    {{ $marca->nombre }}
                </option>
            @endforeach
        </select>
        @error('marca_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Modelo --}}
    <div>
        <label for="modelo" class="block text-sm font-medium text-gray-700 mb-1">Modelo</label>
        <input type="text" name="modelo" id="modelo"
               value="{{ old('modelo', $maq?->modelo) }}"
               class="w-full rounded-lg border-gray-300">
    </div>

    {{-- Color --}}
    <div>
        <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
        <input type="text" name="color" id="color"
               value="{{ old('color', $maq?->color) }}"
               class="w-full rounded-lg border-gray-300">
    </div>

    {{-- Placas --}}
    <div>
        <label for="placas" class="block text-sm font-medium text-gray-700 mb-1">Placas</label>
        <input type="text" name="placas" id="placas"
               value="{{ old('placas', $maq?->placas) }}"
               class="w-full rounded-lg border-gray-300">
    </div>

    {{-- Estatus --}}
    <div>
        <label for="estatus_id" class="block text-sm font-medium text-gray-700 mb-1">Estatus</label>
        <select name="estatus_id" id="estatus_id" class="w-full rounded-lg border-gray-300">
            <option value="">Seleccionar...</option>
            @foreach ($estatuses as $est)
                <option value="{{ $est->id }}" @selected(old('estatus_id', $maq?->estatus_id) == $est->id)>
                    {{ $est->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Responsable --}}
    <div>
        <label for="responsable_id" class="block text-sm font-medium text-gray-700 mb-1">Responsable</label>
        <select name="responsable_id" id="responsable_id" class="w-full rounded-lg border-gray-300">
            <option value="">Sin asignar</option>
            @foreach ($responsables as $user)
                <option value="{{ $user->id }}" @selected(old('responsable_id', $maq?->responsable_id) == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Frente Laboral --}}
    <div>
        <label for="frente_id" class="block text-sm font-medium text-gray-700 mb-1">Frente laboral</label>
        <select name="frente_id" id="frente_id" class="w-full rounded-lg border-gray-300">
            <option value="">Seleccionar...</option>
            @foreach ($frentes as $frente)
                <option value="{{ $frente->id }}" @selected(old('frente_id', $maq?->frente_id) == $frente->id)>
                    {{ $frente->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Ubicación --}}
    <div>
        <label for="ubicacion_id" class="block text-sm font-medium text-gray-700 mb-1">Ubicación</label>
        <select name="ubicacion_id" id="ubicacion_id" class="w-full rounded-lg border-gray-300">
            <option value="">Seleccionar...</option>
            @foreach ($ubicaciones as $ubi)
                <option value="{{ $ubi->id }}" @selected(old('ubicacion_id', $maq?->ubicacion_id) == $ubi->id)>
                    {{ $ubi->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Horómetro --}}
    <div>
        <label for="horometro_actual" class="block text-sm font-medium text-gray-700 mb-1">
            Horómetro actual (hrs)
        </label>
        <input type="number" name="horometro_actual" id="horometro_actual"
               step="0.01" min="0"
               value="{{ old('horometro_actual', $maq?->horometro_actual) }}"
               class="w-full rounded-lg border-gray-300">
    </div>

    {{-- Kilometraje --}}
    <div>
        <label for="kilometraje_actual" class="block text-sm font-medium text-gray-700 mb-1">
            Kilometraje actual (km)
        </label>
        <input type="number" name="kilometraje_actual" id="kilometraje_actual"
               step="0.01" min="0"
               value="{{ old('kilometraje_actual', $maq?->kilometraje_actual) }}"
               class="w-full rounded-lg border-gray-300">
    </div>

    {{-- Notas --}}
    <div class="md:col-span-2">
        <label for="notas" class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
        <textarea name="notas" id="notas" rows="3"
                  class="w-full rounded-lg border-gray-300"
                  placeholder="Observaciones adicionales...">{{ old('notas', $maq?->notas) }}</textarea>
    </div>
</div>