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
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('isAdmin', function ($user) {
            return $user->user_level_id === 'LVL250101001';
        });

        Gate::define('isNoc', function ($user) {
            return $user->user_level_id === 'LVL250101002';
        });

        Gate::define('isSales', function ($user) {
            return $user->user_level_id === 'LVL250101003';
        });
        Gate::define('isKoor', function ($user) {
            return $user->user_level_id === 'LVL241223002';
        });
    }
}
