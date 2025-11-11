<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define Gate: Only petugas can create denda
        Gate::define('create-denda', function ($user) {
            return $user->role === 'petugas';
        });

        // Define Gate: Only admin can confirm payment
        Gate::define('confirm-payment', function ($user) {
            return $user->role === 'admin';
        });
    }
}
