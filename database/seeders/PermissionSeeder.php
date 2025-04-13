<?php

namespace Database\Seeders;

use App\Models\Access\Menu;
use App\Models\Access\Permission;
use App\Models\Access\Route;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // permisos
        $permissionIndex = Permission::create(['name' => 'permissions.index', 'description' => 'Listar permisos', 'is_system' => 1, 'include' => '', 'parent_id' => 0, 'created_user_id' => 0]);
        $parentId = $permissionIndex->id;

        $permissionShow =  Permission::create(['name' => 'permissions.show', 'description' => 'Mostrar detalles de permisos', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionCreate = Permission::create(['name' => 'permissions.create', 'description' => 'Agregar permisos', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionUpdate = Permission::create(['name' => 'permissions.update', 'description' => 'Actualizar permisos', 'is_system' => 1, 'include' => 'permissions.enable',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionEnable = Permission::create(['name' => 'permissions.enable', 'description' => 'Habilitar/desabilitar permisos', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionDestroy = Permission::create(['name' => 'permissions.destroy', 'description' => 'Eliminar permisos', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionLog = Permission::create(['name' => 'permissions.logs', 'description' => 'Mostrar logs de permisos', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);

        //Rutas
        $data = [
            ['route' => 'permissions.index', 'description' => 'Listar permisos', 'parent_id' => $parentId, 'linkable' => 1, 'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'permissions.dataTable', 'description' => 'Datatable de permisos', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'permissions.create', 'description' => 'Mostrar formulario de creación de permisos', 'parent_id' => $parentId, 'linkable' => 1,  'permission_id' => $permissionCreate->id, 'created_user_id' => 0],
            //['route' => 'permissions.validateForm', 'description' => 'Validar datos de menú', 'parent_id' => $parentId, 'linkable' => 0, 'created_user_id' => 0],
            ['route' => 'permissions.store', 'description' => 'Crear menú', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionCreate->id, 'created_user_id' => 0],
            ['route' => 'permissions.show', 'description' => 'Mostrar detalles de permisos', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionShow->id, 'created_user_id' => 0],
            ['route' => 'permissions.edit', 'description' => 'Mostrar formulario de edición de permisos', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionUpdate->id, 'created_user_id' => 0],
            ['route' => 'permissions.update', 'description' => 'Actualizar datos de permisos', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionUpdate->id, 'created_user_id' => 0],
            ['route' => 'permissions.destroy', 'description' => 'Eliminar permisos', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionDestroy->id, 'created_user_id' => 0],
            ['route' => 'permissions.enable', 'description' => 'Habilitar permisos', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionEnable->id, 'created_user_id' => 0],
            ['route' => 'permissions.disable', 'description' => 'Desabilitar permisos', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionEnable->id, 'created_user_id' => 0],
            ['route' => 'permissions.logs', 'description' => 'Mostrar logs de permisos', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionLog->id, 'created_user_id' => 0]
        ];
        Route::insert($data);

        //Menu
        $menuParent =  Menu::where('name', 'Control de acceso')->first();
        $route =  Route::where('route', 'permissions.index')->first();
        Menu::create(['name' => 'Permisos', 'icon' => '', 'parent_id' => $menuParent->id,  'route_id' => $route->id, 'created_user_id' => 0, 'position' => 0]);
    }
}
