<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('acces-admin', function(User $user) {
            return $user->role === 'admin'; 
        });

        Gate::define('acces-attente', function(User $user) {
            return $user->role === 'entrepreneur_en_attente';
        });
    }

}

