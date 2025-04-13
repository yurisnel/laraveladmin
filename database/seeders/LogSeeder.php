<?php

namespace Database\Seeders;

use App\Models\Access\Menu;
use App\Models\Access\Permission;
use App\Models\Access\Route;
use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //permisos     
        $permissionIndex = Permission::create(['name' => 'logs.index', 'description' => 'Listar logs', 'is_system' => 1, 'include' => '', 'parent_id' => 0, 'created_user_id' => 0]);
        $parentId = $permissionIndex->id;

        $permissionShow = Permission::create(['name' => 'logs.show', 'description' => 'Mostrar detalles de logs', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionDestroy = Permission::create(['name' => 'logs.destroy', 'description' => 'Eliminar logs', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);

        //Rutas
        $data = [
            ['route' => 'logs.events.index', 'description' => 'Listar logs de eventos', 'parent_id' => $parentId, 'linkable' => 1, 'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'logs.events.dataTable', 'description' => 'Datatable logs de eventos', 'parent_id' => $parentId, 'linkable' => 1,  'permission_id' => $permissionShow->id, 'created_user_id' => 0],
            ['route' => 'logs.events.show', 'description' => 'Mostrar detalles log de eventos', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionShow->id, 'created_user_id' => 0],
            ['route' => 'logs.events.destroy', 'description' => 'Eliminar log de eventos', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionDestroy->id, 'created_user_id' => 0],
        ];
        Route::insert($data);

        $data = [
            ['route' => 'logs.errors.index', 'description' => 'Listar logs de errores', 'parent_id' => $parentId, 'linkable' => 1, 'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'logs.errors.dataTable', 'description' => 'Datatable logs de errores', 'parent_id' => $parentId, 'linkable' => 1,  'permission_id' => $permissionShow->id, 'created_user_id' => 0],
            ['route' => 'logs.errors.show', 'description' => 'Mostrar detalles log de errores', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionShow->id, 'created_user_id' => 0],
            ['route' => 'logs.errors.destroy', 'description' => 'Eliminar log de errores', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionDestroy->id, 'created_user_id' => 0],
        ];
        Route::insert($data);

        // Menu
        $menuParent = Menu::create(['name' => 'Logs', 'icon' => 'fa fa-history', 'parent_id' => 0, 'created_user_id' => 0]);

        $route =  Route::where('route', 'logs.events.index')->first();
        Menu::create(['name' => 'Eventos', 'icon' => '', 'parent_id' => $menuParent->id,  'route_id' => $route->id, 'created_user_id' => 0]);

        $route =  Route::where('route', 'logs.errors.index')->first();
        Menu::create(['name' => 'Errores', 'icon' => '', 'parent_id' => $menuParent->id,  'route_id' => $route->id, 'created_user_id' => 0]);
    }
}
