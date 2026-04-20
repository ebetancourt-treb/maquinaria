@php $current = $item ?? null; @endphp
<div class="space-y-4">
    @foreach ($campos as $campo)
        @if($campo['type'] === 'checkbox')
            <div><label class="inline-flex items-center">
                <input type="hidden" name="{{ $campo['name'] }}" value="0">
                <input type="checkbox" name="{{ $campo['name'] }}" value="1" class="rounded border-gray-300 text-blue-600" @checked(old($campo['name'], $current?->{$campo['name']} ?? true))>
                <span class="ml-2 text-sm text-gray-700">{{ $campo['label'] }}</span>
            </label></div>
        @elseif($campo['type'] === 'select')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ $campo['label'] }} @if($campo['required'] ?? false)<span class="text-red-500">*</span>@endif</label>
                <select name="{{ $campo['name'] }}" class="w-full rounded-lg border-gray-300" {{ ($campo['required'] ?? false) ? 'required' : '' }}>
                    <option value="">Seleccionar...</option>
                    @foreach ($campo['options'] as $val => $label)<option value="{{ $val }}" @selected(old($campo['name'], $current?->{$campo['name']}) === $val)>{{ $label }}</option>@endforeach
                </select>
                @error($campo['name'])<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        @else
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ $campo['label'] }} @if($campo['required'] ?? false)<span class="text-red-500">*</span>@endif</label>
                <input type="{{ $campo['type'] }}" name="{{ $campo['name'] }}" value="{{ old($campo['name'], $current?->{$campo['name']}) }}" placeholder="{{ $campo['placeholder'] ?? '' }}" class="w-full rounded-lg border-gray-300" {{ ($campo['required'] ?? false) ? 'required' : '' }}>
                @error($campo['name'])<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        @endif
    @endforeach
</div>
