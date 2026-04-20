<?php

namespace Database\Seeders;

use App\Models\{TipoMaquinaria, Marca, EstatusMaquinaria, Ubicacion, FrenteLaboral};
use Illuminate\Database\Seeder;

class CatalogosSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['nombre'=>'Bailarina','prefijo_id'=>'BA','tipo_medicion'=>'horometro'],
            ['nombre'=>'Camioneta','prefijo_id'=>'CA','tipo_medicion'=>'kilometraje'],
            ['nombre'=>'Excavadora','prefijo_id'=>'EX','tipo_medicion'=>'horometro'],
            ['nombre'=>'Vibrocompactador','prefijo_id'=>'VC','tipo_medicion'=>'horometro'],
            ['nombre'=>'Retroexcavadora','prefijo_id'=>'RE','tipo_medicion'=>'horometro'],
            ['nombre'=>'Cargador Frontal','prefijo_id'=>'CF','tipo_medicion'=>'horometro'],
            ['nombre'=>'Pipa','prefijo_id'=>'PI','tipo_medicion'=>'kilometraje'],
            ['nombre'=>'Maxilight LED','prefijo_id'=>'ML','tipo_medicion'=>'horometro'],
            ['nombre'=>'Grúa','prefijo_id'=>'GR','tipo_medicion'=>'horometro'],
            ['nombre'=>'Motoniveladora','prefijo_id'=>'MN','tipo_medicion'=>'horometro'],
            ['nombre'=>'Bomba de agua 3"','prefijo_id'=>'B3','tipo_medicion'=>'horometro'],
            ['nombre'=>'Cortadora','prefijo_id'=>'CO','tipo_medicion'=>'horometro'],
            ['nombre'=>'Dobladora','prefijo_id'=>'DO','tipo_medicion'=>'ninguno'],
            ['nombre'=>'Remolque','prefijo_id'=>'RM','tipo_medicion'=>'ninguno'],
            ['nombre'=>'Telehandler','prefijo_id'=>'TH','tipo_medicion'=>'horometro'],
            ['nombre'=>'Bomba de 6"','prefijo_id'=>'B6','tipo_medicion'=>'horometro'],
            ['nombre'=>'Tractocamión','prefijo_id'=>'TC','tipo_medicion'=>'kilometraje'],
        ];
        foreach ($tipos as $t) { TipoMaquinaria::firstOrCreate(['nombre'=>$t['nombre']], $t); }

        $marcas = ['Jaguar','BOMAG','Develon','Nissan','Sany','TONKA','Chevrolet','New Holland','Simpedil','Italtower','International','Honda','Ford','Volvo','Case','MIKASA','Wacker Neuson','Kobelco','Manitex','Peterbilt','Kenworth','Starling','Witzco Challenger','Sitrak','Pessato'];
        foreach ($marcas as $m) { Marca::firstOrCreate(['nombre'=>$m]); }

        $estatus = [
            ['nombre'=>'DISPONIBLE','color_badge'=>'green'],['nombre'=>'OBRA','color_badge'=>'blue'],
            ['nombre'=>'NUEVO','color_badge'=>'green'],['nombre'=>'FUNCIONAL','color_badge'=>'yellow'],
            ['nombre'=>'NO FUNCIONAL','color_badge'=>'red'],['nombre'=>'OFICINA','color_badge'=>'gray'],
        ];
        foreach ($estatus as $e) { EstatusMaquinaria::firstOrCreate(['nombre'=>$e['nombre']], $e); }

        $ubicaciones = ['COLEGIO','OBRA DE TOMA','MURO DE MAMPOSTERIA','CAMPO DE FUTBOL','PLANTA POTABILIZADORA','LINEA DE CONDUCCION','ACERO'];
        foreach ($ubicaciones as $u) { Ubicacion::firstOrCreate(['nombre'=>$u]); }

        $frentes = ['PLANTA','OBRA DE TOMA','RESIDENTE','COLEGIO','ADMINISTRATIVO','TOPOGRAFIA','MECANICO','COMPOSTA LINEA DE ACERO','CAMPO DE FUTBOL','CALIDAD','MEDIO AMBIENTE','SEGURIDAD','REPARTIDOR DIESEL','NAGUAL'];
        foreach ($frentes as $f) { FrenteLaboral::firstOrCreate(['nombre'=>$f]); }
    }
}
