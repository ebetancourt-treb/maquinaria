<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\EstatusMaquinaria;

class EstatusController extends Controller
{
    use CatalogoBaseTrait;

    protected string $model = EstatusMaquinaria::class;
    protected string $viewFolder = 'estatus';
    protected string $routeName = 'estatus';
    protected string $titulo = 'Estatus de Maquinaria';
    protected string $tituloSingular = 'Estatus';

    protected function campos(): array { return [['name'=>'nombre','label'=>'Nombre','type'=>'text','required'=>true],['name'=>'color_badge','label'=>'Color del badge','type'=>'select','required'=>true,'options'=>['green'=>'Verde','blue'=>'Azul','yellow'=>'Amarillo','red'=>'Rojo','gray'=>'Gris']],['name'=>'activo','label'=>'Activo','type'=>'checkbox','required'=>false]]; }
    protected function reglas($id = null): array { return ['nombre'=>'required|string|max:50|unique:estatus_maquinaria,nombre,'.$id,'color_badge'=>'required|in:green,blue,yellow,red,gray','activo'=>'sometimes|boolean']; }
}
