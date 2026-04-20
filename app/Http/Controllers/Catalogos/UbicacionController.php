<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion;

class UbicacionController extends Controller
{
    use CatalogoBaseTrait;

    protected string $model = Ubicacion::class;
    protected string $viewFolder = 'ubicaciones';
    protected string $routeName = 'ubicaciones';
    protected string $titulo = 'Ubicaciones';
    protected string $tituloSingular = 'Ubicación';

    protected function campos(): array { return [['name'=>'nombre','label'=>'Nombre','type'=>'text','required'=>true],['name'=>'activo','label'=>'Activo','type'=>'checkbox','required'=>false]]; }
    protected function reglas($id = null): array { return ['nombre'=>'required|string|max:150|unique:ubicaciones,nombre,'.$id,'activo'=>'sometimes|boolean']; }
}
