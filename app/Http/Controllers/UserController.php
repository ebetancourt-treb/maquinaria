<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->withCount('maquinariasAsignadas')->orderBy('name')->paginate(25);
        return view('usuarios.index', compact('users'));
    }

    public function create() { return view('usuarios.create', ['roles'=>Role::orderBy('name')->get()]); }

    public function store(Request $request)
    {
        $data = $request->validate(['name'=>'required|string|max:255','email'=>'required|email|unique:users,email','password'=>['required','confirmed',Password::defaults()],'telefono'=>'nullable|string|max:20','puesto'=>'nullable|string|max:100','activo'=>'sometimes|boolean','role'=>'required|exists:roles,name']);
        $user = User::create(['name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'telefono'=>$data['telefono']??null,'puesto'=>$data['puesto']??null,'activo'=>$data['activo']??true]);
        $user->assignRole($data['role']);
        return redirect()->route('usuarios.index')->with('success', "Usuario {$user->name} creado.");
    }

    public function edit(User $usuario) { return view('usuarios.edit', ['usuario'=>$usuario, 'roles'=>Role::orderBy('name')->get()]); }

    public function update(Request $request, User $usuario)
    {
        $data = $request->validate(['name'=>'required|string|max:255','email'=>['required','email',Rule::unique('users')->ignore($usuario->id)],'password'=>['nullable','confirmed',Password::defaults()],'telefono'=>'nullable|string|max:20','puesto'=>'nullable|string|max:100','activo'=>'sometimes|boolean','role'=>'required|exists:roles,name']);
        $usuario->update(['name'=>$data['name'],'email'=>$data['email'],'telefono'=>$data['telefono']??null,'puesto'=>$data['puesto']??null,'activo'=>$data['activo']??true]);
        if (!empty($data['password'])) $usuario->update(['password'=>bcrypt($data['password'])]);
        $usuario->syncRoles([$data['role']]);
        return redirect()->route('usuarios.index')->with('success', "Usuario {$usuario->name} actualizado.");
    }

    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) return back()->with('error', 'No puedes eliminarte a ti mismo.');
        $usuario->update(['activo'=>false]);
        return redirect()->route('usuarios.index')->with('success', "Usuario {$usuario->name} desactivado.");
    }
}
