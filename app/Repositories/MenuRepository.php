<?php

namespace App\Repositories;

use App\Models\Access\Menu;
use Illuminate\Container\Container as Application;


class MenuRepository extends BaseRepository
{

    public function __construct(Application $app)
    {
        parent::__construct($app, Menu::class);
    }

    public function rules($id): array
    {
        if (!$id) {
            $rules = [
                'route_id' => 'numeric|nullable|exists:routes,id',
                'url' => 'url_exist|nullable',
                'parent_id' => 'numeric|nullable',
                'name' => 'required|string|max:50',
                'state' => 'numeric|between:0,1',
            ];
        } else {
            $rules = [
                'route_id' => 'numeric|nullable|exists:routes,id',
                'url' => 'url_exist|nullable',
                'parent_id' => 'numeric|nullable',
                'name' => 'string|max:50',
                'state' => 'numeric|between:0,1',
            ];
        }
        return  $rules;
    }

    public function authDestroy($route): bool
    {
        return true;
    }

    function getMenuParents()
    {
        return Menu::with('children')->where('parent_id', 0)->where('state', 1)->get();
    }
}
