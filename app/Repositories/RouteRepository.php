<?php

namespace App\Repositories;

use App\Models\Access\Route;
use Illuminate\Container\Container as Application;
use Illuminate\Validation\Rule;

class RouteRepository extends BaseRepository
{

    public function __construct(Application $app)
    {
        parent::__construct($app, Route::class);
    }

    public function rules($id): array
    {
        if (!$id) {
            $rules = [
                'parent_id' => 'integer|min:0',
                'route' => 'required|string|max:50|route_exist',
                'description' => 'required|max:50',
                'linkable' => 'numeric|between:0,1',
                'state' => 'numeric|between:0,1'
            ];
        } else {
            $rules = [
                'parent_id' => 'integer|min:0',
                'route' => ['string', 'max:50', 'route_exist', Rule::unique('routes')->ignore($id)],
                'description' => 'max:50',
                'linkable' => 'numeric|between:0,1',
                'state' => 'numeric|between:0,1'
            ];
        }
        return  $rules;
    }

    public function authDestroy($route): bool
    {
        return $this->validExistRelation($route, $route->menu, "menus");
    }

    function getRoutesParents()
    {
        $query = Route::with('children')->where('parent_id', 0);

        return $query->get();
    }

    function getRoutesPermissionAsoc()
    {
        return Route::with('permission')->get()->pluck('permission.name', 'route');
    }
    function getRoutesAvailable()
    {
        $query = $this->model->where('linkable', 1)->where('state', 1);
        return $query->get();
    }
}
