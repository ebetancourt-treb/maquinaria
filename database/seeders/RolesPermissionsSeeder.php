<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permisos = [
            'maquinarias.ver','maquinarias.crear','maquinarias.editar',
            'maquinarias.eliminar','maquinarias.importar','maquinarias.exportar',
            'catalogos.ver','catalogos.gestionar',
            'usuarios.ver','usuarios.gestionar',
            'dashboard.ver',
            'bitacora.ver','bitacora.registrar','bitacora.editar','bitacora.eliminar',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permisos);

        $supervisor = Role::firstOrCreate(['name' => 'supervisor']);
        $supervisor->syncPermissions([
            'maquinarias.ver','maquinarias.crear','maquinarias.editar',
            'maquinarias.importar','maquinarias.exportar',
            'catalogos.ver','catalogos.gestionar','dashboard.ver',
            'bitacora.ver','bitacora.registrar','bitacora.editar',
        ]);

        $operador = Role::firstOrCreate(['name' => 'operador']);
        $operador->syncPermissions(['maquinarias.ver','catalogos.ver','dashboard.ver','bitacora.ver','bitacora.registrar']);
    }
}
