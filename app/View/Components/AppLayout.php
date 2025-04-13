<?php

namespace App\View\Components;

use App\Repositories\MenuRepository;
use App\Repositories\RouteRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Collection;

class AppLayout extends Component
{
    var $appData;
    public function __construct(
        public MenuRepository $repoMenu,
        public RouteRepository $repoRoutes,
        public string $pageTitle,
        public array $breadcrumb
    ) {
        $user = Auth::user();

        $this->appData = [
            'rootUrl' => url('/') . '/',
            'sessionLifetime' => config('session.lifetime'),
            'user' => [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'role_id' => $user->role_id,
                'role_name' => $user->role_name,
                'permissions' => $user->getPermissions(),
            ],
            'routesPermission' => $this->repoRoutes->getRoutesPermissionAsoc(),
            'locale' => __('locale')
        ];
    }
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $mainMenu = $this->repoMenu->getMenuParents();
        $mainMenu = $this->checkAccess($mainMenu);
        return view('layouts.app', compact('mainMenu'));
    }

    protected function checkAccess($menus)
    {
        $result = new Collection();
        foreach ($menus as $menu) {
            $user = Auth::user();
            if (
                (empty($menu->href) || $menu->href == "#") ||
                ($menu->url && $user->hasPermissionUrl($menu->url)) ||
                ($menu->route_id && $user->hasPermissionRouteId($menu->route_id))
            ) {
                $menu->children = $this->checkAccess($menu->children);
                //si es padre y no tiene hijos que mostar
                if ((empty($menu->href) || $menu->href == "#") && $menu->children->count() == 0 ) {
                    continue;
                } else {
                    $result->push($menu);
                }
            }
        }
        return $result;
    }
}
