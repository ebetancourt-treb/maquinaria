<?php

namespace App\Services;

use App\Models\BitacoraRegistro;
use App\Models\Maquinaria;
use Illuminate\Support\Facades\DB;

class BitacoraService
{
    /**
     * Registrar un evento en la bitácora.
     * Actualiza las lecturas y el estatus de la maquinaria en la misma transacción.
     */
    public function registrar(array $data, int $userId): BitacoraRegistro
    {
        return DB::transaction(function () use ($data, $userId) {
            $maquinaria = Maquinaria::with('tipo')->findOrFail($data['maquinaria_id']);

            // Pre-llenar lecturas anteriores desde la máquina
            $data['registrado_por'] = $userId;

            if ($data['tipo_evento'] === 'uso') {
                $data = $this->procesarUso($data, $maquinaria);
            }

            if ($data['tipo_evento'] === 'asignacion') {
                $data = $this->procesarAsignacion($data, $maquinaria);
            }

            $registro = BitacoraRegistro::create($data);

            // Actualizar lecturas en la máquina
            $this->actualizarMaquinaria($registro, $maquinaria);

            return $registro;
        });
    }

    /**
     * Procesa el evento de uso: captura lecturas anteriores automáticamente.
     */
    private function procesarUso(array $data, Maquinaria $maquinaria): array
    {
        if ($maquinaria->usaHorometro()) {
            $data['horometro_anterior'] = $maquinaria->horometro_actual;
        }

        if ($maquinaria->usaKilometraje()) {
            $data['kilometraje_anterior'] = $maquinaria->kilometraje_actual;
        }

        return $data;
    }

    /**
     * Procesa la asignación: captura responsable y frente anteriores.
     */
    private function procesarAsignacion(array $data, Maquinaria $maquinaria): array
    {
        $data['responsable_anterior_id'] = $maquinaria->responsable_id;
        $data['frente_anterior_id'] = $maquinaria->frente_id;

        return $data;
    }

    /**
     * Actualiza la máquina después de registrar un evento.
     */
    private function actualizarMaquinaria(BitacoraRegistro $registro, Maquinaria $maquinaria): void
    {
        $updates = [];

        // Actualizar lecturas de uso
        if ($registro->tipo_evento === 'uso') {
            if ($registro->horometro_actual) {
                $updates['horometro_actual'] = $registro->horometro_actual;
            }
            if ($registro->kilometraje_actual) {
                $updates['kilometraje_actual'] = $registro->kilometraje_actual;
            }
        }

        // Actualizar responsable y frente en asignación
        if ($registro->tipo_evento === 'asignacion') {
            $updates['responsable_id'] = $registro->responsable_nuevo_id;
            if ($registro->frente_nuevo_id) {
                $updates['frente_id'] = $registro->frente_nuevo_id;
            }
        }

        // Actualizar estatus si se indicó
        if ($registro->estatus_resultante_id) {
            $updates['estatus_id'] = $registro->estatus_resultante_id;
        }

        if (!empty($updates)) {
            $maquinaria->update($updates);
        }
    }
}