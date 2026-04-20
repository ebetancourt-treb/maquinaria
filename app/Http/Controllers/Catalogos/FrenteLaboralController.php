<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\FrenteLaboral;

class FrenteLaboralController extends Controller
{
    use CatalogoBaseTrait;

    protected string $model = FrenteLaboral::class;
    protected string $viewFolder = 'frentes';
    protected string $routeName = 'frentes';
    protected string $titulo = 'Frentes Laborales';
    protected string $tituloSingular = 'Frente Laboral';

    protected function campos(): array { return [['name'=>'nombre','label'=>'Nombre','type'=>'text','required'=>true],['name'=>'activo','label'=>'Activo','type'=>'checkbox','required'=>false]]; }
    protected function reglas($id = null): array { return ['nombre'=>'required|string|max:150|unique:frentes_laborales,nombre,'.$id,'activo'=>'sometimes|boolean']; }
}
