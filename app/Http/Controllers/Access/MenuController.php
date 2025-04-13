<?php

namespace App\Http\Controllers\Access;

use App\Http\Controllers\CrudController;
use App\Repositories\MenuRepository;
use App\Repositories\RouteRepository;

class MenuController extends CrudController
{
    protected $repoRoutes;
    public function __construct(MenuRepository $repo, RouteRepository $repoRoutes)
    {
        parent::__construct($repo, 'menus');
        $this->repoRoutes = $repoRoutes;
    }

    public function create()
    {
        $result =  $this->repo->getMenuParents();
        $parents = $result->pluck('name', 'id')->toArray();
        $parents = ["0" => "Root"] + $parents;

        $result =  $this->repoRoutes->getRoutesAvailable();
        $routes = $result->pluck('description', 'id')->toArray();
       
        return View($this->viewCreate, compact('parents', 'routes'));
    }

    public function edit(int $id)
    {
        $item = $this->repo->findByIdOrFail($id);

        $result =  $this->repo->getMenuParents();
        $parents = $result->pluck('name', 'id')->toArray();
        $parents = ["0" => "Root"] + $parents;

        $result =  $this->repoRoutes->getRoutesAvailable();
        $errors = [];
        if ($item->route && $item->route->state == 0) {
            $result->push($item->route);
            $errors['route_id'] = [__('messages.element_disable', ['name' => 'Ruta'])];
        }
        $routes = $result->pluck('description', 'id')->toArray();
        
        return View($this->viewEdit, compact('item', 'parents', 'routes'))->withErrors($errors);
    }
}
