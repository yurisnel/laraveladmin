<?php

namespace App\Repositories;


use App\Models\Access\Permission;
use App\Models\Access\Role;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PermissionRepository extends BaseRepository
{

    public function __construct(Application $app)
    {
        parent::__construct($app, Permission::class);
    }

    public function rules($id): array
    {
        if (!$id) {
            $rules = [
                'parent_id' => 'required|integer|min:0',
                'name' => 'required|string|unique:permissions',
                'description' => 'required|max:50',
            ];
        } else {
            $rules = [
                'parent_id' => 'required|integer|min:0',
                'name' => ['string', 'max:50', Rule::unique('permissions')->ignore($id)],
                'description' => 'max:50',
            ];
        }
        return  $rules;
    }

    public function authDestroy($permission): bool
    {
        return
            $this->validExistRelation($permission, $permission->roles, "roles")
            && $this->validExistRelation($permission, $permission->routes, "rutas");
    }

    public function create(array $attributes)
    {
        $permission = parent::create($attributes);

        /*Agregar por defecto el permiso al rol Superadmin */
        $superAdmin = Role::where('name', 'SuperAdmin')->first();
        $superAdmin->permissions()->attach($permission);
        return $permission;
    }

    function getPermissionsParents()
    {
        $query = Permission::with('children')->where('state', 1)->where('parent_id', 0);

        // si no es superAdmin, solo puede ver los permisos a las que tiene acceso
        $user = auth()->user();
        if ($user->role_id != 1) {
            $permisions =  DB::table('role_permision')->select('permision_id')->where('role_id', $user->role_id);
            $query->whereIn('id', $permisions);
        }

        return $query->get();
    }

    function getPermissionsAvailable()
    {
        $query = $this->model->where('state', 1)/*->where('parent_id', '>', 0)*/;

        return $query->get();
    }
}
