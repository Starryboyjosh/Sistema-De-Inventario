<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $modulos = ['empresas', 'sucursales', 'areas', 'categorias', 'unidades_medida', 'proveedores', 'items', 'movimientos', 'reportes'];
        $acciones = ['ver', 'crear', 'editar', 'eliminar'];

        foreach ($modulos as $modulo) {
            foreach ($acciones as $accion) {
                Permission::firstOrCreate(['name' => "$modulo.$accion"]);
            }
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->syncPermissions(Permission::all());

        $adminEmpresa = Role::firstOrCreate(['name' => 'admin_empresa']);
        $adminEmpresa->syncPermissions(
            Permission::whereNotIn('name', ['empresas.crear', 'empresas.editar', 'empresas.eliminar'])->get()
        );

        $encargadoArea = Role::firstOrCreate(['name' => 'encargado_area']);
        $encargadoArea->syncPermissions([
            'areas.ver',
            'items.ver',
            'movimientos.ver',
            'movimientos.crear',
            'reportes.ver',
        ]);

        $consulta = Role::firstOrCreate(['name' => 'consulta']);
        $consulta->syncPermissions([
            'empresas.ver',
            'sucursales.ver',
            'areas.ver',
            'items.ver',
            'movimientos.ver',
            'reportes.ver',
        ]);
    }
}
