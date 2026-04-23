<?php

namespace App\Providers;

use App\Models\Residence;
use App\Models\User;
use App\Observers\ResidenceObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
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
        // Register model observers
        Residence::observe(ResidenceObserver::class);
        User::observe(UserObserver::class);

        // Add directives Blade for roles and permissions

        Blade::if('permission', function ($permission) {
            return Auth::check() && Auth::user()->hasPermission($permission);
        });
        Blade::if('role', function ($role) {
            return Auth::check() && Auth::user()->hasRole($role);
        });
    }
}
