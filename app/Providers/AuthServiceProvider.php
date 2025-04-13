<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Validation\Rules;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Rules\Password::defaults(function () {
            $rule = Rules\Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols();
            
            /*return $this->app->isProduction()
                ? $rule->mixedCase()->uncompromised()
                : $rule;*/
                
            return $rule;
        });
    }
}
