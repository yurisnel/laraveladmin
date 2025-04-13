<?php

namespace App\Http\Controllers\Access;

use App\Http\Controllers\CrudController;
use App\Repositories\PermissionRepository;
use App\Repositories\RouteRepository;


class RouteController extends CrudController
{
    protected $fieldFilterText = "description";
    protected PermissionRepository $repoPermission;
    public function __construct(RouteRepository $repo, PermissionRepository $repoPermission)
    {
        parent::__construct($repo, 'routes');
        $this->repoPermission = $repoPermission;
    }

    public function create()
    {
        $result =  $this->repoPermission->getPermissionsAvailable();
        $permissions = $result->pluck('description', 'id')->toArray();
        return View($this->viewCreate, compact('permissions'));
    }

    public function edit(int $id)
    {
        $item = $this->repo->findByIdOrFail($id);

        $result =  $this->repoPermission->getPermissionsAvailable();
        $errors = [];
        if ($item->permission && $item->permission->state == 0) {
            $result->push($item->permission);
            $errors['permission_id'] = [__('messages.element_disable', ['name' => 'Permiso'])];
        }
        $permissions = $result->pluck('description', 'id')->toArray();

        return View($this->viewEdit, compact('item', 'permissions'))->withErrors($errors);
    }

    public function update(int $id)
    {
        $data = request()->all();
        if (!isset($data['linkable'])) {
            $data['linkable'] = '0';
        }

        $modelObjet = $this->repo->update($data, $id);
        $title =  __('messages.success');
        $success =  __('messages.element_update_ok', ['name' => $modelObjet->__toString()]);
        return $this->reponseMixted($title, $success);
    }
}
