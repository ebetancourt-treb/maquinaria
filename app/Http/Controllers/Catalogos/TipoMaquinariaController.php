<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\TipoMaquinaria;

class TipoMaquinariaController extends Controller
{
    use CatalogoBaseTrait;

    protected string $model = TipoMaquinaria::class;
    protected string $viewFolder = 'tipos';
    protected string $routeName = 'tipos';
    protected string $titulo = 'Tipos de Maquinaria';
    protected string $tituloSingular = 'Tipo';

    protected function campos(): array { return [['name'=>'nombre','label'=>'Nombre','type'=>'text','required'=>true],['name'=>'prefijo_id','label'=>'Prefijo ID','type'=>'text','required'=>true,'placeholder'=>'Ej: BA, EX'],['name'=>'tipo_medicion','label'=>'Tipo de medición','type'=>'select','required'=>true,'options'=>['ninguno'=>'Sin medición','horometro'=>'Horómetro','kilometraje'=>'Kilometraje','ambos'=>'Ambos']],['name'=>'descripcion','label'=>'Descripción','type'=>'text','required'=>false],['name'=>'activo','label'=>'Activo','type'=>'checkbox','required'=>false]]; }
    protected function reglas($id = null): array { return ['nombre'=>'required|string|max:100|unique:tipos_maquinaria,nombre,'.$id,'prefijo_id'=>'required|string|max:10|unique:tipos_maquinaria,prefijo_id,'.$id,'tipo_medicion'=>'required|in:horometro,kilometraje,ambos,ninguno','descripcion'=>'nullable|string|max:255','activo'=>'sometimes|boolean']; }
}
