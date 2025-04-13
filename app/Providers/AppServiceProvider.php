<?php

namespace App\Providers;

use App\Helpers\Helper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use \Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Helpers/helper-functions.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('url_exist', function ($attribute, $value, $parameters, $validator) {
            try {
                $route = Route::getRoutes()->match(Request::create($value));
                return true;
            } catch (Exception $exception) {
                return false;
            }
        });

        Validator::extend('route_exist', function ($attribute, $value, $parameters, $validator) {
            return Route::has($value);
        });

        $this->app->singleton('App\Helpers\Helper', function () {
            return new Helper();
        });
    }
}
