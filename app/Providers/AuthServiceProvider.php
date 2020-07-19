<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
       // Passport::loadKeysFrom('/secret-keys/oauth');

        Gate::define('isAdmin', function () {
            return auth()->check();
        });

        Gate::define('isOwner', function ($user,$endroit) {
            return true;//$user->role == 'admin' || $endroit->user_id == Auth::user()->id;
        });
    }
}
