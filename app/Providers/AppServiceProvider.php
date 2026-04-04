<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            if ($user->hasRole(Role::SUPER_ADMIN)) {
                return true;
            }

            return null;
        });
        // Add directives Blade for roles and permissions

        Blade::if('permission', function ($permission) {
            return Auth::check() && Auth::user()->hasPermission($permission);
        });
        Blade::if('role', function ($role) {
            return Auth::check() && Auth::user()->hasRole($role);
        });
    }
}
