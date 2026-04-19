<?php

namespace App\Imports;

use App\Models\{
    Maquinaria, TipoMaquinaria, Marca,
    EstatusMaquinaria, Ubicacion, FrenteLaboral, User
};
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Str;

class MaquinariasImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use Importable;

    public int $importados = 0;
    public int $omitidos = 0;

    /**
     * Mapeo columnas Excel → modelo.
     * Heading row se normaliza a snake_case.
     */
    public function model(array $row)
    {
        // Normalizar campos
        $tipoNombre   = trim($row['tipo'] ?? '');
        $marcaNombre  = trim($row['marca'] ?? '');
        $identificador = trim($row['id'] ?? '');

        if (empty($tipoNombre) || empty($marcaNombre)) {
            $this->omitidos++;
            return null;
        }

        // Si el identificador ya existe, omitir (no duplicar)
        if ($identificador && $identificador !== 'X') {
            if (Maquinaria::where('identificador', $identificador)->exists()) {
                $this->omitidos++;
                return null;
            }
        }

        // Catálogos: firstOrCreate para auto-registrar nuevos
        $tipo = TipoMaquinaria::firstOrCreate(
            ['nombre' => $tipoNombre],
            ['prefijo_id' => Str::upper(Str::substr($tipoNombre, 0, 2))]
        );

        $marca = Marca::firstOrCreate(['nombre' => $marcaNombre]);

        $estatus = !empty($row['estatus'])
            ? EstatusMaquinaria::firstOrCreate(
                ['nombre' => Str::upper(trim($row['estatus']))]
            ) : null;

        $ubicacion = !empty($row['ubicacion'])
            ? Ubicacion::firstOrCreate(['nombre' => trim($row['ubicacion'])])
            : null;

        // Buscar responsable por nombre parcial
        $responsable = !empty($row['responsble'])
            ? User::where('name', 'like', '%' . trim($row['responsble']) . '%')->first()
            : null;

        // Generar identificador si no tiene o es "X"
        if (empty($identificador) || $identificador === 'X') {
            $identificador = Maquinaria::generarIdentificador($tipo);
        }

        $this->importados++;

        return new Maquinaria([
            'tipo_id'        => $tipo->id,
            'numero_serie'   => $row['no_de_serie'] ?? null,
            'identificador'  => $identificador,
            'descripcion'    => trim($row['descripcion'] ?? $tipoNombre),
            'color'          => $row['color'] ?? null,
            'marca_id'       => $marca->id,
            'modelo'         => $row['modelo'] ?? null,
            'placas'         => $row['placas'] ?? null,
            'responsable_id' => $responsable?->id,
            'estatus_id'     => $estatus?->id,
            'ubicacion_id'   => $ubicacion?->id,
        ]);
    }

    public function rules(): array
    {
        return [
            'tipo'        => 'required|string',
            'descripcion' => 'nullable|string',
            'marca'       => 'required|string',
        ];
    }
}