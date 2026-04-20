<?php

namespace App\Services;

use App\Models\BitacoraRegistro;
use App\Models\Maquinaria;
use Illuminate\Support\Facades\DB;

class BitacoraService
{
    public function registrar(array $data, int $userId): BitacoraRegistro
    {
        return DB::transaction(function () use ($data, $userId) {
            $maquinaria = Maquinaria::with('tipo')->findOrFail($data['maquinaria_id']);
            $data['registrado_por'] = $userId;

            if ($data['tipo_evento'] === 'uso') {
                if ($maquinaria->usaHorometro()) $data['horometro_anterior'] = $maquinaria->horometro_actual;
                if ($maquinaria->usaKilometraje()) $data['kilometraje_anterior'] = $maquinaria->kilometraje_actual;
            }

            if ($data['tipo_evento'] === 'asignacion') {
                $data['responsable_anterior_id'] = $maquinaria->responsable_id;
                $data['frente_anterior_id'] = $maquinaria->frente_id;
            }

            $registro = BitacoraRegistro::create($data);

            $updates = [];
            if ($registro->tipo_evento === 'uso') {
                if ($registro->horometro_actual) $updates['horometro_actual'] = $registro->horometro_actual;
                if ($registro->kilometraje_actual) $updates['kilometraje_actual'] = $registro->kilometraje_actual;
            }
            if ($registro->tipo_evento === 'asignacion') {
                $updates['responsable_id'] = $registro->responsable_nuevo_id;
                if ($registro->frente_nuevo_id) $updates['frente_id'] = $registro->frente_nuevo_id;
            }
            if ($registro->estatus_resultante_id) $updates['estatus_id'] = $registro->estatus_resultante_id;
            if (!empty($updates)) $maquinaria->update($updates);

            return $registro;
        });
    }
}
