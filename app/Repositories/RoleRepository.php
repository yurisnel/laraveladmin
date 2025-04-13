<?php

namespace App\Repositories;

use App\Exceptions\ExceptionCustom;
use App\Models\Access\Permission;
use App\Models\Access\Role;
use Illuminate\Container\Container as Application;
use \Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class RoleRepository extends BaseRepository
{

    public function __construct(Application $app)
    {
        parent::__construct($app, Role::class);
    }

    public function rules($id): array
    {
        if (!$id) {
            $rules = [
                'name' => 'required|string|max:50|unique:roles,name',
                'description' => 'max:50',
                'routes' => 'nullable|array',
                'state' => 'numeric|between:0,1',
            ];
        } else {
            $rules = [
                'name' => ['string', 'max:50', Rule::unique('roles')->ignore($id)],
                'description' => 'max:50',
                'routes' => 'nullable|array',
                'state' => 'numeric|between:0,1',
            ];
        }
        return  $rules;
    }

    public function authDestroy($role): bool
    {
        return $this->validExistRelation($role, $role->users, "usuarios");
    }

    public function create(array $attributes)
    {
        $role = parent::create($attributes);

        if (isset($attributes['permissions'])) {
            $permissions = $attributes['permissions'];
            $this->addIncludes($permissions);
            $permissions = array_unique($permissions, SORT_REGULAR);
            $role->permissions()->attach($permissions);
        }
        return $role;
    }

    public function update(array $attributes, $id)
    {
        if ($id == 1) {
            throw new ExceptionCustom(__('messages.not_access'), Response::HTTP_FORBIDDEN);
        }

        $role = parent::update($attributes, $id);

        if (!empty($attributes['permissions'])) {
            $permissions = $attributes['permissions'];
            $this->addIncludes($permissions);
            $permissions = array_unique($permissions, SORT_REGULAR);
            $role->permissions()->sync($permissions);
        } else {
            $role->permissions()->detach(); // Eliminar todas las asociaciones si no se seleccionaron rutas
        }

        return $role;
    }

    protected function addIncludes(&$permissions)
    {
        $includeName = [];
        $permissionsIncludes = Permission::where('include', '<>', '')->whereIn('id', $permissions)->get();
        foreach ($permissionsIncludes as $permission) {
            array_push($includeName,  explode(",", $permission->include));
        }
        $permissionsIncludes = Permission::whereIn('name', $includeName)->get();
        $includeIds = $permissionsIncludes->pluck('id')->toArray();
        for ($i = 0; $i < count($includeIds); $i++) {
            array_push($permissions, $includeIds[$i]);
        }
    }
    function getRolesAvailable()
    {
        $query = $this->model->where('state', 1);

        // si no es superAdmin, solo puede ver los roles que ha creado el o su admin
        /*$user = auth()->user();
        if ($user->role_id != 1) {
            $query->whereIn('created_user_id', [$user->id, $user->created_user_id]);
        }*/

        return $query->get();
    }

    function getRolesAvailableToClient()
    {
        $query = $this->model->where('state', 1);
        $query->whereNotIn('name', ['SuperAdmin']);
        return $query->get();
    }
}
