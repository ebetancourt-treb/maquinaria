<?php

namespace App\Http\Controllers;

use App\Http\Requests\BitacoraRegistroRequest;
use App\Models\{BitacoraRegistro, Maquinaria, EstatusMaquinaria, FrenteLaboral, User};
use App\Services\BitacoraService;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    public function __construct(private BitacoraService $bitacoraService) {}

    public function index(Request $request)
    {
        $registros = BitacoraRegistro::query()
            ->with(['maquinaria.tipo','maquinaria.marca','registrador','estatusResultante'])
            ->when($request->filled('tipo_evento'), fn($q)=>$q->where('tipo_evento',$request->tipo_evento))
            ->when($request->filled('maquinaria_id'), fn($q)=>$q->where('maquinaria_id',$request->maquinaria_id))
            ->when($request->filled('desde'), fn($q)=>$q->where('fecha_evento','>=',$request->desde))
            ->when($request->filled('hasta'), fn($q)=>$q->where('fecha_evento','<=',$request->hasta.' 23:59:59'))
            ->orderByDesc('fecha_evento')->paginate(25)->withQueryString();
        return view('bitacora.index', [
            'registros'=>$registros,
            'maquinarias'=>Maquinaria::with('tipo')->orderBy('identificador')->get(),
            'usuarios'=>User::activos()->orderBy('name')->get(),
        ]);
    }

    public function timeline(Maquinaria $maquinaria, Request $request)
    {
        $maquinaria->load(['tipo','marca','estatus','responsable','frente','ubicacion']);
        $registros = $maquinaria->bitacora()
            ->with(['registrador','estatusResultante','responsableAnterior','responsableNuevo','frenteAnterior','frenteNuevo'])
            ->when($request->filled('tipo_evento'), fn($q)=>$q->where('tipo_evento',$request->tipo_evento))
            ->paginate(20)->withQueryString();
        $stats = [
            'total_registros'=>$maquinaria->bitacora()->count(),
            'total_mantenimientos'=>$maquinaria->bitacora()->deMantenimiento()->count(),
            'total_incidencias'=>$maquinaria->bitacora()->deIncidencia()->count(),
            'costo_mantenimiento'=>$maquinaria->bitacora()->deMantenimiento()->sum('costo'),
            'ultimo_mantenimiento'=>$maquinaria->bitacora()->deMantenimiento()->latest('fecha_evento')->value('fecha_evento'),
            'proximo_mantenimiento'=>$maquinaria->bitacora()->deMantenimiento()->whereNotNull('proximo_mantenimiento')->where('proximo_mantenimiento','>=',now())->orderBy('proximo_mantenimiento')->value('proximo_mantenimiento'),
        ];
        return view('bitacora.timeline', compact('maquinaria','registros','stats'));
    }

    public function create(Request $request)
    {
        $maquinaria = $request->filled('maquinaria_id') ? Maquinaria::with('tipo')->findOrFail($request->maquinaria_id) : null;
        return view('bitacora.create', [
            'maquinaria'=>$maquinaria,
            'maquinarias'=>Maquinaria::with('tipo')->orderBy('identificador')->get(),
            'responsables'=>User::activos()->orderBy('name')->get(),
            'frentes'=>FrenteLaboral::activos()->orderBy('nombre')->get(),
            'estatuses'=>EstatusMaquinaria::activos()->orderBy('nombre')->get(),
            'tipoEvento'=>$request->get('tipo_evento', 'uso'),
        ]);
    }

    public function store(BitacoraRegistroRequest $request)
    {
        $registro = $this->bitacoraService->registrar($request->validated(), auth()->id());
        return redirect()->route('bitacora.timeline', $registro->maquinaria)->with('success', "Registro de {$registro->etiqueta_evento} guardado.");
    }

    public function show(BitacoraRegistro $registro)
    {
        $registro->load(['maquinaria.tipo','maquinaria.marca','registrador','responsableAnterior','responsableNuevo','frenteAnterior','frenteNuevo','estatusResultante']);
        return view('bitacora.show', compact('registro'));
    }
}
