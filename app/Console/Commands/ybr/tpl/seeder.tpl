<?php

namespace Database\Seeders;

use App\Models\Access\Menu;
use App\Models\Access\Permission;
use App\Models\Access\Route;
use Illuminate\Database\Seeder;


class NAME_MODELSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //permisos        
        $permissionIndex = Permission::create(['name' => 'NAME_TABLE.index', 'description' => 'Listar NAME_TABLE', 'is_system' => 1, 'include' => '', 'parent_id' => 0, 'created_user_id' => 0]);
        $parentId = $permissionIndex->id;

        $permissionShow = Permission::create(['name' => 'NAME_TABLE.show', 'description' => 'Mostrar detalles de NAME_TABLE', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionCreate = Permission::create(['name' => 'NAME_TABLE.create', 'description' => 'Agregar NAME_TABLE', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionUpdate = Permission::create(['name' => 'NAME_TABLE.update', 'description' => 'Actualizar NAME_TABLE', 'is_system' => 1, 'include' => 'NAME_TABLE.enable',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionEnable = Permission::create(['name' => 'NAME_TABLE.enable', 'description' => 'Habilitar/desabilitar NAME_TABLE', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionDestroy = Permission::create(['name' => 'NAME_TABLE.destroy', 'description' => 'Eliminar NAME_TABLE', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionLog = Permission::create(['name' => 'NAME_TABLE.logs', 'description' => 'Mostrar logs de NAME_TABLE', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);

        Permission::assignToRole('NAME_TABLE.', 'SuperAdmin');

        //rutas       
        $data = [
            ['route' => 'NAME_TABLE.index', 'description' => 'Listar NAME_TABLE', 'parent_id' => $parentId, 'linkable' => 1, 'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'NAME_TABLE.dataTable', 'description' => 'Datatable de NAME_TABLE', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'NAME_TABLE.create', 'description' => 'Mostrar formulario de creación de NAME_TABLE', 'parent_id' => $parentId, 'linkable' => 1,  'permission_id' => $permissionCreate->id, 'created_user_id' => 0],
            ['route' => 'NAME_TABLE.store', 'description' => 'Crear NAME_TABLE', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionCreate->id, 'created_user_id' => 0],
            ['route' => 'NAME_TABLE.show', 'description' => 'Mostrar detalles de NAME_TABLE', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionShow->id, 'created_user_id' => 0],
            ['route' => 'NAME_TABLE.edit', 'description' => 'Mostrar formulario de edición de NAME_TABLE', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionUpdate->id, 'created_user_id' => 0],
            ['route' => 'NAME_TABLE.update', 'description' => 'Actualizar datos de NAME_TABLE', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionUpdate->id, 'created_user_id' => 0],
            ['route' => 'NAME_TABLE.destroy', 'description' => 'Eliminar NAME_TABLE', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionDestroy->id, 'created_user_id' => 0],
            ['route' => 'NAME_TABLE.enable', 'description' => 'Habilitar NAME_TABLE', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionEnable->id, 'created_user_id' => 0],
            ['route' => 'NAME_TABLE.disable', 'description' => 'Desabilitar NAME_TABLE', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionEnable->id, 'created_user_id' => 0],
            ['route' => 'NAME_TABLE.logs', 'description' => 'Mostrar logs de NAME_TABLE', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionLog->id, 'created_user_id' => 0]
        ];
        Route::insert($data);

        //Menu
        $route =  Route::where('route', 'NAME_TABLE.index')->first();
        Menu::create(['name' => 'NAME_TABLE', 'icon' => 'fa fa-products-hunt', 'parent_id' => 0, 'route_id' => $route->id, 'created_user_id' => 0]);
    }
}
