<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BitacoraRegistroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            // Comunes a todos
            'maquinaria_id'  => 'required|exists:maquinarias,id',
            'tipo_evento'    => ['required', Rule::in([
                'uso', 'mantenimiento', 'asignacion', 'incidencia', 'inspeccion'
            ])],
            'fecha_evento'   => 'required|date|before_or_equal:now',
            'observaciones'  => 'nullable|string|max:2000',
            'estatus_resultante_id' => 'nullable|exists:estatus_maquinaria,id',
        ];

        // Reglas condicionales por tipo de evento
        $tipo = $this->input('tipo_evento');

        if ($tipo === 'uso') {
            $rules += [
                'horometro_actual'    => 'nullable|numeric|min:0',
                'kilometraje_actual'  => 'nullable|numeric|min:0',
            ];
        }

        if ($tipo === 'mantenimiento') {
            $rules += [
                'tipo_mantenimiento'      => ['required', Rule::in(['preventivo', 'correctivo'])],
                'descripcion_trabajo'     => 'required|string|max:2000',
                'costo'                   => 'nullable|numeric|min:0',
                'proveedor'               => 'nullable|string|max:150',
                'proximo_mantenimiento'   => 'nullable|date|after:today',
            ];
        }

        if ($tipo === 'asignacion') {
            $rules += [
                'responsable_nuevo_id' => 'required|exists:users,id',
                'frente_nuevo_id'      => 'nullable|exists:frentes_laborales,id',
                'motivo_asignacion'    => 'nullable|string|max:255',
            ];
        }

        if ($tipo === 'incidencia') {
            $rules += [
                'tipo_incidencia' => ['required', Rule::in([
                    'falla_mecanica', 'falla_electrica', 'accidente',
                    'robo', 'vandalismo', 'desgaste',
                ])],
                'severidad'     => ['required', Rule::in(['baja', 'media', 'alta', 'critica'])],
                'accion_tomada' => 'nullable|string|max:2000',
                'requiere_paro' => 'boolean',
            ];
        }

        if ($tipo === 'inspeccion') {
            $rules += [
                'estado_general'  => ['required', Rule::in(['bueno', 'regular', 'malo'])],
                'checklist_json'  => 'nullable|array',
                'aprobado'        => 'nullable|boolean',
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'fecha_evento.before_or_equal' => 'La fecha no puede ser futura.',
            'descripcion_trabajo.required' => 'Describe el trabajo realizado.',
            'responsable_nuevo_id.required' => 'Selecciona al nuevo responsable.',
            'tipo_incidencia.required'     => 'Selecciona el tipo de incidencia.',
            'estado_general.required'      => 'Indica el estado general del equipo.',
            'proximo_mantenimiento.after'  => 'La fecha del próximo mantenimiento debe ser futura.',
        ];
    }
}