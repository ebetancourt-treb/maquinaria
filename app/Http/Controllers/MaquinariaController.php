<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaquinariaRequest;
use App\Models\{
    Maquinaria,
    TipoMaquinaria,
    Marca,
    EstatusMaquinaria,
    Ubicacion,
    FrenteLaboral,
    User
};
use Illuminate\Http\Request;

class MaquinariaController extends Controller
{
    /**
     * Listado con filtros + búsqueda + paginación.
     */
    public function index(Request $request)
    {
        $maquinarias = Maquinaria::query()
            ->with(['tipo', 'marca', 'estatus', 'responsable', 'frente', 'ubicacion'])
            ->when($request->filled('tipo_id'), fn ($q) =>
                $q->where('tipo_id', $request->tipo_id))
            ->when($request->filled('marca_id'), fn ($q) =>
                $q->where('marca_id', $request->marca_id))
            ->when($request->filled('estatus_id'), fn ($q) =>
                $q->where('estatus_id', $request->estatus_id))
            ->when($request->filled('frente_id'), fn ($q) =>
                $q->where('frente_id', $request->frente_id))
            ->when($request->filled('responsable_id'), fn ($q) =>
                $q->where('responsable_id', $request->responsable_id))
            ->when($request->filled('buscar'), fn ($q) =>
                $q->where(function ($q2) use ($request) {
                    $q2->where('identificador', 'like', "%{$request->buscar}%")
                       ->orWhere('numero_serie', 'like', "%{$request->buscar}%")
                       ->orWhere('descripcion', 'like', "%{$request->buscar}%")
                       ->orWhere('placas', 'like', "%{$request->buscar}%");
                }))
            ->orderBy('identificador')
            ->paginate(25)
            ->withQueryString();

        return view('maquinarias.index', [
            'maquinarias'  => $maquinarias,
            'tipos'        => TipoMaquinaria::activos()->orderBy('nombre')->get(),
            'marcas'       => Marca::activos()->orderBy('nombre')->get(),
            'estatuses'    => EstatusMaquinaria::activos()->orderBy('nombre')->get(),
            'frentes'      => FrenteLaboral::activos()->orderBy('nombre')->get(),
            'responsables' => User::activos()->orderBy('name')->get(),
        ]);
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        return view('maquinarias.create', $this->formData());
    }

    /**
     * Guardar nueva maquinaria.
     */
    public function store(MaquinariaRequest $request)
    {
        $data = $request->validated();

        // Generar identificador si no se proporcionó
        if (empty($data['identificador'])) {
            $tipo = TipoMaquinaria::findOrFail($data['tipo_id']);
            $data['identificador'] = Maquinaria::generarIdentificador($tipo);
        }

        Maquinaria::create($data);

        return redirect()
            ->route('maquinarias.index')
            ->with('success', "Maquinaria {$data['identificador']} registrada correctamente.");
    }

    /**
     * Detalle de una máquina con resumen de bitácora.
     */
    public function show(Maquinaria $maquinaria)
    {
        $maquinaria->load([
            'tipo', 'marca', 'estatus', 'responsable',
            'frente', 'ubicacion',
            'ultimoMantenimiento', 'ultimoRegistroUso',
        ]);

        $ultimosRegistros = $maquinaria->bitacora()
            ->with('registrador')
            ->limit(5)
            ->get();

        return view('maquinarias.show', compact('maquinaria', 'ultimosRegistros'));
    }

    /**
     * Formulario de edición.
     */
    public function edit(Maquinaria $maquinaria)
    {
        $maquinaria->load('tipo');

        return view('maquinarias.edit', array_merge(
            $this->formData(),
            ['maquinaria' => $maquinaria]
        ));
    }

    /**
     * Actualizar maquinaria existente.
     */
    public function update(MaquinariaRequest $request, Maquinaria $maquinaria)
    {
        $maquinaria->update($request->validated());

        return redirect()
            ->route('maquinarias.show', $maquinaria)
            ->with('success', "Maquinaria {$maquinaria->identificador} actualizada.");
    }

    /**
     * Eliminar (soft delete).
     */
    public function destroy(Maquinaria $maquinaria)
    {
        $id = $maquinaria->identificador;
        $maquinaria->delete();

        return redirect()
            ->route('maquinarias.index')
            ->with('success', "Maquinaria {$id} eliminada.");
    }

    /**
     * Datos comunes para los formularios create/edit.
     */
    private function formData(): array
    {
        return [
            'tipos'        => TipoMaquinaria::activos()->orderBy('nombre')->get(),
            'marcas'       => Marca::activos()->orderBy('nombre')->get(),
            'estatuses'    => EstatusMaquinaria::activos()->orderBy('nombre')->get(),
            'frentes'      => FrenteLaboral::activos()->orderBy('nombre')->get(),
            'ubicaciones'  => Ubicacion::activos()->orderBy('nombre')->get(),
            'responsables' => User::activos()->orderBy('name')->get(),
        ];
    }
}