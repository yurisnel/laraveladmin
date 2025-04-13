<?php

namespace App\Http\Controllers\Access;

use App\Exceptions\ExceptionCustom;
use App\Http\Controllers\CrudController;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;


class UserController extends CrudController
{
    protected RoleRepository $repoRoles;

    public function __construct(UserRepository $repo, RoleRepository $repoRoles)
    {
        parent::__construct($repo, 'users');
        $this->repoRoles = $repoRoles;
    }

    public function create()
    {
        $result =  $this->repoRoles->getRolesAvailable();
        $roles = $result->pluck('name', 'id')->toArray();
        return View($this->viewCreate, compact('roles'));
    }

    public function edit(int $id)
    {
        $item = $this->repo->findByIdOrFail($id);
        $result =  $this->repoRoles->getRolesAvailable();
        $errors = [];
        if ($item->role && $item->role->state == 0) {
            $result->push($item->role);
            $errors['role_id'] = [__('messages.element_disable', ['name' => 'Role'])];
        }
        $roles = $result->pluck('name', 'id')->toArray();
        return View($this->viewEdit, compact('item', 'roles'))->withErrors($errors);
    }

    public function disable(int $id)
    {
        // buscar si exite otro superAdmin activado
        $superAdmins = $this->repo->findWhere([
            'role_id' => 1,
            'state' => 1,
            ['id', '<>', $id]
        ]);
        if (count($superAdmins) == 0) {
            throw new ExceptionCustom(__('messages.not_access'), Response::HTTP_BAD_REQUEST);
        }
        return parent::disable($id);
    }

    public function resetPassword(int $userId)
    {
        $this->repo->resetPassword($userId);
        return $this->reponseMixted(__('messages.success'), __('messages.request_reset_password_ok'));
    }

    public function userInactive($userId)
    {
        $user = $this->repo->findByIdOrFail($userId);
        $urlActivate = route('user.requestActivation', ['user' => $userId]);
        $titleError = $user->state == 0 ? __('messages.account_inactive') : __('messages.rol_inactive');
        return View('pages.users.inactive', compact('urlActivate', 'titleError'));
    }

    public function requestUserActivation(int $userId)
    {
        $this->repo->requestUserActivation($userId);
        return redirect()->route('login')
            ->with('status', __('messages.request_active_user_ok'));
    }

    public function dataTable($query = null)
    {
        if (!$query) {
            $query = $this->repo->queryPersist();
        }
        $filterText = request()->input('filter_text');
        if ($filterText) {
            $this->fieldFilterText = false;
            $query->where('name', 'LIKE', "%$filterText%")
                ->orWhere('fathername', 'LIKE', "%$filterText%")
                ->orWhere('mothername', 'LIKE', "%$filterText%")
                ->orWhere('dni', 'LIKE', "%$filterText%");
        }

        return parent::dataTable($query);
    }
}
