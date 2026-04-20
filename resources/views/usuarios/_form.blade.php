@php $u = $user ?? null; @endphp

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name', $u?->name) }}"
               class="w-full rounded-lg border-gray-300" required>
        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
        <input type="email" name="email" value="{{ old('email', $u?->email) }}"
               class="w-full rounded-lg border-gray-300" required>
        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Contraseña {{ $u ? '' : '*' }}
            </label>
            <input type="password" name="password"
                   class="w-full rounded-lg border-gray-300"
                   {{ $u ? '' : 'required' }}
                   placeholder="{{ $u ? 'Dejar vacío para no cambiar' : '' }}">
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Confirmar contraseña</label>
            <input type="password" name="password_confirmation"
                   class="w-full rounded-lg border-gray-300">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono', $u?->telefono) }}"
                   class="w-full rounded-lg border-gray-300">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Puesto</label>
            <input type="text" name="puesto" value="{{ old('puesto', $u?->puesto) }}"
                   class="w-full rounded-lg border-gray-300">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Rol <span class="text-red-500">*</span></label>
        <select name="role" class="w-full rounded-lg border-gray-300" required>
            <option value="">Seleccionar rol...</option>
            @foreach ($roles as $role)
                <option value="{{ $role->name }}"
                    @selected(old('role', $u?->roles->first()?->name) === $role->name)>
                    {{ ucfirst($role->name) }}
                </option>
            @endforeach
        </select>
        @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="inline-flex items-center">
            <input type="hidden" name="activo" value="0">
            <input type="checkbox" name="activo" value="1"
                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                   @checked(old('activo', $u?->activo ?? true))>
            <span class="ml-2 text-sm text-gray-700">Usuario activo</span>
        </label>
    </div>
</div>
