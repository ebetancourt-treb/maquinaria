<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MaquinariaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $maquinariaId = $this->route('maquinaria')?->id;

        return [
            'tipo_id'         => 'required|exists:tipos_maquinaria,id',
            'numero_serie'    => 'nullable|string|max:100',
            'identificador'   => [
                'nullable', 'string', 'max:30',
                Rule::unique('maquinarias', 'identificador')->ignore($maquinariaId),
            ],
            'descripcion'     => 'required|string|max:255',
            'color'           => 'nullable|string|max:50',
            'marca_id'        => 'required|exists:marcas,id',
            'modelo'          => 'nullable|string|max:100',
            'placas'          => 'nullable|string|max:30',
            'responsable_id'  => 'nullable|exists:users,id',
            'frente_id'       => 'nullable|exists:frentes_laborales,id',
            'estatus_id'      => 'nullable|exists:estatus_maquinaria,id',
            'ubicacion_id'    => 'nullable|exists:ubicaciones,id',
            'notas'           => 'nullable|string|max:2000',
            'horometro_actual'   => 'nullable|numeric|min:0',
            'kilometraje_actual' => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'tipo_id.required'    => 'Selecciona el tipo de maquinaria.',
            'descripcion.required'=> 'La descripción es obligatoria.',
            'marca_id.required'   => 'Selecciona la marca.',
            'identificador.unique'=> 'Ese identificador ya está registrado.',
        ];
    }
}