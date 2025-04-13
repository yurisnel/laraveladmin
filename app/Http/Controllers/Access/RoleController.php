<?php

namespace App\Http\Controllers\Access;

use App\Http\Controllers\CrudController;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;


class RoleController extends CrudController
{
    protected $repoPermissions;
    public function __construct(RoleRepository $repo, PermissionRepository $repoPermissions)
    {
        parent::__construct($repo, 'roles');
        $this->repoPermissions = $repoPermissions;
    }

    public function create()
    {
        $permisions =  $this->repoPermissions->getPermissionsParents();
        return View($this->viewCreate, compact('permisions'));
    }

    public function edit(int $id)
    {
        $permisions =  $this->repoPermissions->getPermissionsParents();
        $item = $this->repo->findByIdOrFail($id);
        $selected = $item->permissions()->pluck('permissions.id')->toArray();
        return View($this->viewEdit, compact('item', 'permisions', 'selected'));
    }
}
