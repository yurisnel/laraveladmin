<?php

namespace Database\Seeders;

use App\Models\Access\Menu;
use App\Models\Access\Permission;
use App\Models\Access\Role;
use App\Models\Access\Route;
use App\Models\Access\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //permisos
        $permissionIndex = Permission::create(['name' => 'users.index', 'description' => 'Listar usuarios', 'is_system' => 1, 'include' => '', 'parent_id' => 0, 'created_user_id' => 0]);
        $parentId = $permissionIndex->id;

        $permissionShow =  Permission::create(['name' => 'users.show', 'description' => 'Mostrar detalles de usuarios', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionCreate = Permission::create(['name' => 'users.create', 'description' => 'Agregar usuarios', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionUpdate = Permission::create(['name' => 'users.update', 'description' => 'Actualizar usuarios', 'is_system' => 1, 'include' => 'users.enable',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionEnable = Permission::create(['name' => 'users.enable', 'description' => 'Habilitar/desabilitar usuarios', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionResetPassword = Permission::create(['name' => 'users.resetPassword', 'description' => 'Resetar contraseña de usuarios', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionDestroy = Permission::create(['name' => 'users.destroy', 'description' => 'Eliminar usuarios', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);
        $permissionLog = Permission::create(['name' => 'users.logs', 'description' => 'Mostrar logs de usuarios', 'is_system' => 1, 'include' => '',  'parent_id' => $parentId, 'created_user_id' => 0]);

        //rutas
        $data = [
            ['route' => 'users.index', 'description' => 'Listar usuarios', 'parent_id' => $parentId, 'linkable' => 1, 'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'users.dataTable', 'description' => 'Datatable de usuarios', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionIndex->id, 'created_user_id' => 0],
            ['route' => 'users.create', 'description' => 'Mostrar formulario de creación de usuarios', 'parent_id' => $parentId, 'linkable' => 1, 'permission_id' => $permissionCreate->id, 'created_user_id' => 0],
            //['route' => 'users.validateForm', 'description' => 'Validar datos de usuarios', 'parent_id' => $parentId, 'linkable' => 0, 'created_user_id' => 0],
            ['route' => 'users.store', 'description' => 'Crear usuarios', 'parent_id' => $parentId, 'linkable' => 0, 'permission_id' => $permissionCreate->id, 'created_user_id' => 0],
            ['route' => 'users.show', 'description' => 'Mostrar detalles de usuarios', 'parent_id' => $parentId, 'linkable' => 0, 'permission_id' => $permissionShow->id, 'created_user_id' => 0],
            ['route' => 'users.edit', 'description' => 'Mostrar formulario de edición de usuarios', 'parent_id' => $parentId, 'linkable' => 0, 'permission_id' => $permissionUpdate->id, 'created_user_id' => 0],
            ['route' => 'users.update', 'description' => 'Actualizar datos de usuarios', 'parent_id' => $parentId, 'linkable' => 0, 'permission_id' => $permissionUpdate->id, 'created_user_id' => 0],
            ['route' => 'users.destroy', 'description' => 'Eliminar usuarios', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionDestroy->id, 'created_user_id' => 0],
            ['route' => 'users.resetPassword', 'description' => 'Restablecer contraseña de usuarios', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionResetPassword->id, 'created_user_id' => 0],
            ['route' => 'users.enable', 'description' => 'Habilitar usuarios', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionEnable->id, 'created_user_id' => 0],
            ['route' => 'users.disable', 'description' => 'Desabilitar usuarios', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionEnable->id, 'created_user_id' => 0],
            ['route' => 'users.logs', 'description' => 'Mostrar logs usuarios', 'parent_id' => $parentId, 'linkable' => 0,  'permission_id' => $permissionLog->id, 'created_user_id' => 0]
        ];
        Route::insert($data);

        //Menu
        $menuParent =  Menu::where('name', 'Control de acceso')->first();
        $route =  Route::where('route', 'users.index')->first();
        Menu::create(['name' => 'Usuarios', 'icon' => '', 'parent_id' => $menuParent->id,  'route_id' => $route->id, 'created_user_id' => 0, 'position' => 4]);
    }

    public static function createInitAccess()
    {

        $roleSuperAdmin = Role::factory()->create([
            'name' => 'SuperAdmin',
            'description' => 'Full System Access'
        ]);

        $admin = Role::factory()->create([
            'name' => 'Gerente',
            'description' => 'Gestión de empresa'
        ]);

        $employe = Role::factory()->create([
            'name' => 'Empleado',
            'description' => 'Empleado de empresa'
        ]);


        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $roleSuperAdmin->permissions()->attach($permission);
        }

        //$roleSuperAdmin = Role::where('name', 'SuperAdmin')->first();
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@laravel.com',
            'password' => Hash::make('123456'),
            'fathername' => 'Laravel',
            'mothername' => 'SA',
            'dni' => '27.411.259-K',
            'role_id' => $roleSuperAdmin->id,
        ]);
        //$user->roles()->attach($roleSuperAdmin);

        
    }
}
