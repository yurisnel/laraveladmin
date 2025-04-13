<?php

namespace Database\Seeders;

use App\Models\Access\Menu;
use App\Models\Access\Permission;
use App\Models\Access\Route;
use Illuminate\Database\Seeder;


class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // permisos    
        $permissionIndex =  Permission::create(['name' => 'routes.index', 'description' => 'Listar rutas', 'is_system' => 1, 'include' => '', 'parent_id' => 0, 'created_user_id' => 0]);
        $parentId = $permissionIndex->id;

        $permissionShow =  Permission::create(['name' => 'routes.show', 'description' => 'Mostrar detalles de rutas', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionCreate = Permission::create(['name' => 'routes.create', 'description' => 'Agregar rutas', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionUpdate = Permission::create(['name' => 'routes.update', 'description' => 'Actualizar rutas', 'is_system' => 1, 'include' => 'routes.enable',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionEnable = Permission::create(['name' => 'routes.enable', 'description' => 'Habilitar/desabilitar rutas', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionDestroy = Permission::create(['name' => 'routes.destroy', 'description' => 'Eliminar rutas', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionLog = Permission::create(['name' => 'routes.logs', 'description' => 'Mostrar logs de rutas', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);

        //Rutas
        $data = [
            ['route' => 'routes.index', 'description' => 'Listar rutas', 'parent_id' => $parentId, 'linkable' => 1,  'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'routes.dataTable', 'description' => 'Datatable de rutas', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'routes.create', 'description' => 'Mostrar formulario de creación de rutas', 'parent_id' => $parentId, 'linkable' => 1,  'permission_id' => $permissionCreate->id, 'created_user_id' => 0],
            //['route' => 'routes.validateForm', 'description' => 'Validar datos de rutas', 'parent_id' => $parentId, 'linkable' => 0, 'created_user_id' => 0],
            ['route' => 'routes.store', 'description' => 'Crear rutas', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionCreate->id, 'created_user_id' => 0],
            ['route' => 'routes.show', 'description' => 'Mostrar detalles de rutas', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionShow->id, 'created_user_id' => 0],
            ['route' => 'routes.edit', 'description' => 'Mostrar formulario de edición de rutas', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionUpdate->id, 'created_user_id' => 0],
            ['route' => 'routes.update', 'description' => 'Actualizar datos de rutas', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionUpdate->id, 'created_user_id' => 0],
            ['route' => 'routes.destroy', 'description' => 'Eliminar rutas', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionDestroy->id, 'created_user_id' => 0],
            ['route' => 'routes.enable', 'description' => 'Habilitar rutas', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionEnable->id, 'created_user_id' => 0],
            ['route' => 'routes.disable', 'description' => 'Desabilitar rutas', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionEnable->id, 'created_user_id' => 0],
            ['route' => 'routes.logs', 'description' => 'Mostrar logs de rutas', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionLog->id, 'created_user_id' => 0]
        ];
        Route::insert($data);

        //Menu
        $menuParent =  Menu::where('name', 'Control de acceso')->first();
        $route =  Route::where('route', 'routes.index')->first();
        Menu::create(['name' => 'Rutas', 'icon' => '', 'parent_id' => $menuParent->id,  'route_id' => $route->id, 'created_user_id' => 0, 'position' => 1]);
    }
}
