<?php

namespace App\Http\Controllers;

use App\Imports\MaquinariasImport;
use App\Models\Maquinaria;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function maquinarias(Request $request)
    {
        $request->validate(['archivo'=>'required|mimes:xlsx,xls,csv|max:10240']);
        $import = new MaquinariasImport;
        Excel::import($import, $request->file('archivo'));
        return redirect()->route('maquinarias.index')->with('success', "Importación: {$import->importados} importados, {$import->omitidos} omitidos.");
    }

    public function exportar()
    {
        $maquinarias = Maquinaria::with(['tipo','marca','estatus','responsable','frente','ubicacion'])->orderBy('identificador')->get();
        $filename = 'maquinaria_'.date('Y-m-d_His').'.csv';
        $headers = ['Content-Type'=>'text/csv; charset=UTF-8','Content-Disposition'=>"attachment; filename={$filename}"];
        $callback = function() use ($maquinarias) {
            $f = fopen('php://output','w');
            fprintf($f, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($f, ['Tipo','N° Serie','ID','Descripción','Color','Marca','Modelo','Placas','Responsable','Frente','Estatus','Ubicación','Horómetro','Kilometraje']);
            foreach ($maquinarias as $m) {
                fputcsv($f, [$m->tipo->nombre??'',$m->numero_serie??'',$m->identificador,$m->descripcion,$m->color??'',$m->marca->nombre??'',$m->modelo??'',$m->placas??'',$m->responsable->name??'',$m->frente->nombre??'',$m->estatus->nombre??'',$m->ubicacion->nombre??'',$m->horometro_actual,$m->kilometraje_actual]);
            }
            fclose($f);
        };
        return response()->stream($callback, 200, $headers);
    }
}
