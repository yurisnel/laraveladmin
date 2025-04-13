<?php

namespace Database\Seeders;

use App\Models\Access\Menu;
use App\Models\Access\Permission;
use App\Models\Access\Route;
use Illuminate\Database\Seeder;


class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //permisos de empresas

        $permissionIndex = Permission::create(['name' => 'clients.index', 'description' => 'Listar empresas', 'is_system' => 1, 'include' => '', 'parent_id' => 0, 'created_user_id' => 0]);
        $parentId = $permissionIndex->id;

        $permissionShow = Permission::create(['name' => 'clients.show', 'description' => 'Mostrar detalles de empresa', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionCreate = Permission::create(['name' => 'clients.create', 'description' => 'Agregar empresa', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionUpdate = Permission::create(['name' => 'clients.update', 'description' => 'Actualizar empresa', 'is_system' => 1, 'include' => 'clients.enable',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionEnable = Permission::create(['name' => 'clients.enable', 'description' => 'Habilitar/desabilitar empresa', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionDestroy = Permission::create(['name' => 'clients.destroy', 'description' => 'Eliminar empresa', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionLog = Permission::create(['name' => 'clients.logs', 'description' => 'Mostrar logs de empresa', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);

        Permission::assignToRole('clients.', 'SuperAdmin');

        //Rutas de empresas
        $data = [
            ['route' => 'clients.index', 'description' => 'Listar empresas', 'parent_id' => $parentId, 'linkable' => 1, 'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'clients.dataTable', 'description' => 'Datatable de empresas', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'clients.create', 'description' => 'Mostrar formulario de creación de empresa', 'parent_id' => $parentId, 'linkable' => 1,  'permission_id' => $permissionCreate->id, 'created_user_id' => 0],
            ['route' => 'clients.store', 'description' => 'Crear empresa', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionCreate->id, 'created_user_id' => 0],
            ['route' => 'clients.show', 'description' => 'Mostrar detalles de empresa', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionShow->id, 'created_user_id' => 0],
            ['route' => 'clients.edit', 'description' => 'Mostrar formulario de edición de empresa', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionUpdate->id, 'created_user_id' => 0],
            ['route' => 'clients.update', 'description' => 'Actualizar datos de empresa', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionUpdate->id, 'created_user_id' => 0],
            ['route' => 'clients.destroy', 'description' => 'Eliminar empresa', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionDestroy->id, 'created_user_id' => 0],
            ['route' => 'clients.enable', 'description' => 'Habilitar empresa', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionEnable->id, 'created_user_id' => 0],
            ['route' => 'clients.disable', 'description' => 'Desabilitar empresa', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionEnable->id, 'created_user_id' => 0],
            ['route' => 'clients.logs', 'description' => 'Mostrar logs de empresa', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionLog->id, 'created_user_id' => 0]
        ];
        Route::insert($data);

        //Menu
        $menuParent =  Menu::where('name', 'Mantenedores')->first();
        $route =  Route::where('route', 'clients.index')->first();
        Menu::create(['name' => 'Empresas', 'icon' => '', 'parent_id' => $menuParent->id,  'route_id' => $route->id, 'created_user_id' => 0]);
    }
}
