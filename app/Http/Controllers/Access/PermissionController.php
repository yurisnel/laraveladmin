<?php

namespace App\Http\Controllers\Access;

use App\Http\Controllers\CrudController;
use App\Repositories\PermissionRepository;

class PermissionController extends CrudController
{
    public function __construct(PermissionRepository $repo)
    {
        parent::__construct($repo, 'permissions');
    }

    public function create()
    {
        $result =  $this->repo->getPermissionsParents();
        $parents = $result->pluck('description', 'id')->toArray();
        return View($this->viewCreate, compact('parents'));
    }

    public function edit(int $id)
    {
        $result =  $this->repo->getPermissionsParents();
        $parents = $result->pluck('description', 'id')->toArray();
        $item = $this->repo->findByIdOrFail($id);
        return View($this->viewEdit, compact('item', 'parents'));
    }
}
