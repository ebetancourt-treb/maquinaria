<?php

namespace Database\Seeders;

use App\Models\{TipoMaquinaria, Marca, EstatusMaquinaria, Ubicacion, FrenteLaboral};
use Illuminate\Database\Seeder;

class CatalogosSeeder extends Seeder
{
    public function run(): void
    {
        // ── Tipos (del Excel analizado) ──
        $tipos = [
            ['nombre' => 'Bailarina',        'prefijo_id' => 'BA'],
            ['nombre' => 'Camioneta',        'prefijo_id' => 'CA'],
            ['nombre' => 'Excavadora',       'prefijo_id' => 'EX'],
            ['nombre' => 'Vibrocompactador', 'prefijo_id' => 'VC'],
            ['nombre' => 'Retroexcavadora',  'prefijo_id' => 'RE'],
            ['nombre' => 'Cargador Frontal', 'prefijo_id' => 'CF'],
            ['nombre' => 'Pipa',             'prefijo_id' => 'PI'],
            ['nombre' => 'Maxilight LED',    'prefijo_id' => 'ML'],
            ['nombre' => 'Grúa',             'prefijo_id' => 'GR'],
            ['nombre' => 'Motoniveladora',   'prefijo_id' => 'MN'],
            ['nombre' => 'Bomba de agua 3"', 'prefijo_id' => 'B3'],
            ['nombre' => 'Cortadora',        'prefijo_id' => 'CO'],
            ['nombre' => 'Dobladora',        'prefijo_id' => 'DO'],
            ['nombre' => 'Remolque',         'prefijo_id' => 'RM'],
            ['nombre' => 'Telehandler',      'prefijo_id' => 'TH'],
            ['nombre' => 'Bomba de 6"',      'prefijo_id' => 'B6'],
            ['nombre' => 'Tractocamión',     'prefijo_id' => 'TC'],
        ];
        foreach ($tipos as $t) {
            TipoMaquinaria::firstOrCreate(['nombre' => $t['nombre']], $t);
        }

        // ── Marcas (normalizadas del Excel) ──
        $marcas = [
            'Jaguar', 'BOMAG', 'Develon', 'Nissan', 'Sany', 'TONKA',
            'Chevrolet', 'New Holland', 'Simpedil', 'Italtower',
            'International', 'Honda', 'Ford', 'Volvo', 'Case',
            'MIKASA', 'Wacker Neuson', 'Kobelco', 'Manitex', 'Peterbilt',
            'Kenworth', 'Starling', 'Witzco Challenger', 'Sitrak', 'Pessato',
        ];
        foreach ($marcas as $m) {
            Marca::firstOrCreate(['nombre' => $m]);
        }

        // ── Estatus ──
        $estatus = [
            ['nombre' => 'DISPONIBLE',    'color_badge' => 'green'],
            ['nombre' => 'OBRA',          'color_badge' => 'blue'],
            ['nombre' => 'NUEVO',         'color_badge' => 'green'],
            ['nombre' => 'FUNCIONAL',     'color_badge' => 'yellow'],
            ['nombre' => 'NO FUNCIONAL',  'color_badge' => 'red'],
            ['nombre' => 'OFICINA',       'color_badge' => 'gray'],
        ];
        foreach ($estatus as $e) {
            EstatusMaquinaria::firstOrCreate(['nombre' => $e['nombre']], $e);
        }

        // ── Ubicaciones (del Excel) ──
        $ubicaciones = [
            'COLEGIO', 'OBRA DE TOMA', 'MURO DE MAMPOSTERIA',
            'CAMPO DE FUTBOL', 'PLANTA POTABILIZADORA',
            'LINEA DE CONDUCCION', 'ACERO',
        ];
        foreach ($ubicaciones as $u) {
            Ubicacion::firstOrCreate(['nombre' => $u]);
        }

        // ── Frentes Laborales (del Excel) ──
        $frentes = [
            'PLANTA', 'OBRA DE TOMA', 'RESIDENTE', 'COLEGIO',
            'ADMINISTRATIVO', 'TOPOGRAFIA', 'MECANICO',
            'COMPOSTA LINEA DE ACERO', 'CAMPO DE FUTBOL',
            'CALIDAD', 'MEDIO AMBIENTE', 'SEGURIDAD',
            'REPARTIDOR DIESEL', 'NAGUAL',
        ];
        foreach ($frentes as $f) {
            FrenteLaboral::firstOrCreate(['nombre' => $f]);
        }
    }
}