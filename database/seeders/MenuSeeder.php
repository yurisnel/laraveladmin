<?php

namespace Database\Seeders;

use App\Models\Access\Menu;
use App\Models\Access\Permission;
use App\Models\Access\Route;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Permisos
        $permissionIndex = Permission::create(['name' => 'menus.index', 'description' => 'Listar menus', 'is_system' => 1, 'include' => '', 'parent_id' => 0, 'created_user_id' => 0]);
        $parentId = $permissionIndex->id;

        $permissionShow = Permission::create(['name' => 'menus.show', 'description' => 'Mostrar detalles de menus', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionCreate = Permission::create(['name' => 'menus.create', 'description' => 'Agregar menus', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionUpdate = Permission::create(['name' => 'menus.update', 'description' => 'Actualizar menus', 'is_system' => 1, 'include' => 'menus.enable',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionEnable = Permission::create(['name' => 'menus.enable', 'description' => 'Habilitar/desabilitar menus', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionDestroy = Permission::create(['name' => 'menus.destroy', 'description' => 'Eliminar menus', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionLog = Permission::create(['name' => 'menus.logs', 'description' => 'Mostrar logs de menu', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);

        //Rutas
        $data = [
            ['route' => 'menus.index', 'description' => 'Listar menú', 'parent_id' => $parentId, 'linkable' => 1, 'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'menus.dataTable', 'description' => 'Datatable de menú', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'menus.create', 'description' => 'Mostrar formulario de creación de menú', 'parent_id' => $parentId, 'linkable' => 1,  'permission_id' => $permissionCreate->id, 'created_user_id' => 0],
            //['route' => 'menus.validateForm', 'description' => 'Validar datos de menú', 'parent_id' => $parentId, 'linkable' => 0, 'created_user_id' => 0],
            ['route' => 'menus.store', 'description' => 'Crear menú', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionCreate->id, 'created_user_id' => 0],
            ['route' => 'menus.show', 'description' => 'Mostrar detalles de menú', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionShow->id, 'created_user_id' => 0],
            ['route' => 'menus.edit', 'description' => 'Mostrar formulario de edición de menú', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionUpdate->id, 'created_user_id' => 0],
            ['route' => 'menus.update', 'description' => 'Actualizar datos de menú', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionUpdate->id, 'created_user_id' => 0],
            ['route' => 'menus.destroy', 'description' => 'Eliminar menú', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionDestroy->id, 'created_user_id' => 0],
            ['route' => 'menus.enable', 'description' => 'Habilitar menú', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionEnable->id, 'created_user_id' => 0],
            ['route' => 'menus.disable', 'description' => 'Desabilitar menú', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionEnable->id, 'created_user_id' => 0],
            ['route' => 'menus.logs', 'description' => 'Mostrar logs de menú', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionLog->id, 'created_user_id' => 0]
        ];
        Route::insert($data);

        //Menu
        Menu::create(['name' => 'Dashboard', 'icon' => 'fa fa-house', 'parent_id' => 0, 'url' => 'dashboard', 'created_user_id' => 0]);
        Menu::create(['name' => 'Mantenedores', 'icon' => 'fa fa-database', 'parent_id' => 0, 'created_user_id' => 0]);
        $menuParent = Menu::create(['name' => 'Control de acceso', 'icon' => 'fa fa-person-walking-arrow-right', 'parent_id' => 0, 'created_user_id' => 0]);

        $route =  Route::where('route', 'menus.index')->first();
        Menu::create(['name' => 'Menus', 'icon' => '', 'parent_id' => $menuParent->id,  'route_id' => $route->id, 'created_user_id' => 0, 'position' => 2]);
    }
}
