<?php

namespace App\Http\Controllers\Catalogos;

use Illuminate\Http\Request;

trait CatalogoBaseTrait
{
    public function index()
    {
        $items = $this->model::orderBy('nombre')->paginate(25);
        return view("catalogos.{$this->viewFolder}.index", ['items'=>$items, 'titulo'=>$this->titulo]);
    }
    public function create() { return view("catalogos.{$this->viewFolder}.create", ['titulo'=>$this->titulo, 'campos'=>$this->campos()]); }
    public function store(Request $request)
    {
        $this->model::create($request->validate($this->reglas()));
        return redirect()->route("catalogos.{$this->routeName}.index")->with('success', "{$this->tituloSingular} creado.");
    }
    public function edit($id)
    {
        return view("catalogos.{$this->viewFolder}.edit", ['item'=>$this->model::findOrFail($id), 'titulo'=>$this->titulo, 'campos'=>$this->campos()]);
    }
    public function update(Request $request, $id)
    {
        $this->model::findOrFail($id)->update($request->validate($this->reglas($id)));
        return redirect()->route("catalogos.{$this->routeName}.index")->with('success', "{$this->tituloSingular} actualizado.");
    }
    public function destroy($id)
    {
        $item = $this->model::findOrFail($id);
        if (method_exists($item, 'maquinarias') && $item->maquinarias()->count() > 0) {
            $item->update(['activo'=>false]);
            return redirect()->route("catalogos.{$this->routeName}.index")->with('success', "{$this->tituloSingular} desactivado.");
        }
        $item->delete();
        return redirect()->route("catalogos.{$this->routeName}.index")->with('success', "{$this->tituloSingular} eliminado.");
    }
}
