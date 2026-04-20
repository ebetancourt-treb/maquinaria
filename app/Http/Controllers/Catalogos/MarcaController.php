<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Marca;

class MarcaController extends Controller
{
    use CatalogoBaseTrait;

    protected string $model = Marca::class;
    protected string $viewFolder = 'marcas';
    protected string $routeName = 'marcas';
    protected string $titulo = 'Marcas';
    protected string $tituloSingular = 'Marca';

    protected function campos(): array { return [['name'=>'nombre','label'=>'Nombre','type'=>'text','required'=>true],['name'=>'activo','label'=>'Activo','type'=>'checkbox','required'=>false]]; }
    protected function reglas($id = null): array { return ['nombre'=>'required|string|max:100|unique:marcas,nombre,'.$id,'activo'=>'sometimes|boolean']; }
}
