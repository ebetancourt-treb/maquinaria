<?php

namespace App\Http\Controllers;

use App\Models\{Maquinaria, TipoMaquinaria, FrenteLaboral, BitacoraRegistro, User};

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            // ── KPIs de inventario ──
            'totalEquipos'  => Maquinaria::count(),
            'disponibles'   => Maquinaria::disponible()->count(),
            'enObra'        => Maquinaria::enObra()->count(),
            'noFuncionales' => Maquinaria::whereHas('estatus',
                fn($q) => $q->where('nombre', 'NO FUNCIONAL'))->count(),

            // ── KPIs de bitácora ──
            'registrosHoy'   => BitacoraRegistro::whereDate('fecha_evento', today())->count(),
            'registrosSemana'=> BitacoraRegistro::where('fecha_evento', '>=', now()->startOfWeek())->count(),
            'incidenciasAbiertas' => Maquinaria::conIncidenciasAbiertas()->count(),
            'mantenimientosProximos' => Maquinaria::conMantenimientoProximo(7)->count(),

            // ── Costos de mantenimiento últimos 30 días ──
            'costoMantenimiento30d' => BitacoraRegistro::deMantenimiento()
                ->where('fecha_evento', '>=', now()->subDays(30))
                ->sum('costo'),

            // ── Últimos 10 registros de bitácora ──
            'ultimosRegistros' => BitacoraRegistro::with(['maquinaria.tipo', 'registrador'])
                ->orderByDesc('fecha_evento')
                ->limit(10)
                ->get(),

            // ── Alertas: próximos mantenimientos ──
            'alertasMantenimiento' => BitacoraRegistro::deMantenimiento()
                ->with('maquinaria.tipo')
                ->whereNotNull('proximo_mantenimiento')
                ->where('proximo_mantenimiento', '<=', now()->addDays(7))
                ->where('proximo_mantenimiento', '>=', now())
                ->orderBy('proximo_mantenimiento')
                ->limit(10)
                ->get(),

            // ── Distribuciones ──
            'porTipo' => TipoMaquinaria::withCount('maquinarias')
                ->orderByDesc('maquinarias_count')->get(),

            'porFrente' => FrenteLaboral::withCount('maquinarias')
                ->orderByDesc('maquinarias_count')->get(),

            // ── Alertas de calidad de datos ──
            'sinPlacas'      => Maquinaria::whereNull('placas')->count(),
            'sinUbicacion'   => Maquinaria::whereNull('ubicacion_id')->count(),
            'sinResponsable' => Maquinaria::whereNull('responsable_id')->count(),
        ]);
    }
}