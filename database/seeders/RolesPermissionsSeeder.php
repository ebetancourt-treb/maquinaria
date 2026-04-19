<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permisos = [
            // Maquinaria
            'maquinarias.ver',
            'maquinarias.crear',
            'maquinarias.editar',
            'maquinarias.eliminar',
            'maquinarias.importar',
            'maquinarias.exportar',
            // Catálogos
            'catalogos.ver',
            'catalogos.gestionar',
            // Usuarios
            'usuarios.ver',
            'usuarios.gestionar',
            // Dashboard
            'dashboard.ver',
            'bitacora.ver',
            'bitacora.registrar',
            'bitacora.editar',
            'bitacora.eliminar',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // ── Admin: todo ──
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permisos);

        // ── Supervisor: opera sin gestionar usuarios ──
        $supervisor = Role::firstOrCreate(['name' => 'supervisor']);
        $supervisor->syncPermissions([
            'maquinarias.ver', 'maquinarias.crear', 'maquinarias.editar',
            'maquinarias.importar', 'maquinarias.exportar',
            'catalogos.ver', 'catalogos.gestionar',
            'dashboard.ver','bitacora.ver', 'bitacora.registrar', 'bitacora.editar',


        ]);

        // ── Operador: solo consulta ──
        $operador = Role::firstOrCreate(['name' => 'operador']);
        $operador->syncPermissions([
            'maquinarias.ver',
            'catalogos.ver',
            'dashboard.ver',
            'bitacora.ver', 'bitacora.registrar',

        ]);
    }
}
