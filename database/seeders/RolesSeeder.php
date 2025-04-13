<?php

namespace Database\Seeders;

use App\Models\Access\Menu;
use App\Models\Access\Permission;
use App\Models\Access\Route;
use Illuminate\Database\Seeder;


class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {       
        //permisos
        $permissionIndex = Permission::create(['name' => 'roles.index', 'description' => 'Listar roles', 'is_system' => 1, 'include' => '', 'parent_id' => 0, 'created_user_id' => 0]);
        $parentId = $permissionIndex->id;

        $permissionShow = Permission::create(['name' => 'roles.show', 'description' => 'Mostrar detalles de roles', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionCreate = Permission::create(['name' => 'roles.create', 'description' => 'Agregar roles', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionUpdate = Permission::create(['name' => 'roles.update', 'description' => 'Actualizar roles', 'is_system' => 1, 'include' => 'roles.enable',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionEnable = Permission::create(['name' => 'roles.enable', 'description' => 'Habilitar/desabilitar roles', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionDestroy = Permission::create(['name' => 'roles.destroy', 'description' => 'Eliminar roles', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionLog = Permission::create(['name' => 'roles.logs', 'description' => 'Mostrar logs de roles', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);

        //rutas       
        $data = [
            ['route' => 'roles.index', 'description' => 'Listar roles', 'parent_id' => $parentId, 'linkable' => 1,  'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'roles.dataTable', 'description' => 'Datatable de roles', 'parent_id' =>  $parentId, 'linkable' => 0,  'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'roles.create', 'description' => 'Mostrar formulario de creación de roles', 'parent_id' =>  $parentId, 'linkable' => 1,  'permission_id' => $permissionCreate->id, 'created_user_id' => 0],
            //['route' => 'roles.validateForm', 'description' => 'Validar datos de roles', 'parent_id' => $parentId, 'linkable' => 0, 'created_user_id' => 0],
            ['route' => 'roles.store', 'description' => 'Crear roles', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionCreate->id, 'created_user_id' => 0],
            ['route' => 'roles.show', 'description' => 'Mostrar detalles de roles', 'parent_id' =>  $parentId, 'linkable' => 0,  'permission_id' => $permissionShow->id, 'created_user_id' => 0],
            ['route' => 'roles.edit', 'description' => 'Mostrar formulario de edición de roles', 'parent_id' =>  $parentId, 'linkable' => 0,  'permission_id' => $permissionUpdate->id, 'created_user_id' => 0],
            ['route' => 'roles.update', 'description' => 'Actualizar datos de roles', 'parent_id' =>  $parentId, 'linkable' => 0,  'permission_id' => $permissionUpdate->id, 'created_user_id' => 0],
            ['route' => 'roles.destroy', 'description' => 'Eliminar roles', 'parent_id' =>  $parentId, 'linkable' => 0,  'permission_id' => $permissionDestroy->id, 'created_user_id' => 0],
            ['route' => 'roles.enable', 'description' => 'Habilitar roles', 'parent_id' =>  $parentId, 'linkable' => 0,  'permission_id' => $permissionEnable->id, 'created_user_id' => 0],
            ['route' => 'roles.disable', 'description' => 'Desabilitar roles', 'parent_id' =>  $parentId, 'linkable' => 0,  'permission_id' => $permissionEnable->id, 'created_user_id' => 0],
            ['route' => 'roles.logs', 'description' => 'Mostrar logs roles', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionLog->id, 'created_user_id' => 0]
        ];
        Route::insert($data);

        //Menu
        $menuParent =  Menu::where('name', 'Control de acceso')->first();
        $route =  Route::where('route', 'roles.index')->first();
        Menu::create(['name' => 'Roles', 'icon' => '', 'parent_id' => $menuParent->id,  'route_id' => $route->id, 'created_user_id' => 0, 'position' => 3]);
    }
}
