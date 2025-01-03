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

        Gate::define('isAdminOrNoc', function ($user) {
            $allowedLevels = ['LVL250101001', 'LVL250101002']; // Admin dan NOC
            return in_array($user->user_level_id, $allowedLevels);
        });

        // Kombinasi Gates
        Gate::define('isAdminAndSales', function ($user) {
            return in_array($user->user_level_id, ['LVL250101001', 'LVL250101003']);
        });

        Gate::define('isNocAndSales', function ($user) {
            return in_array($user->user_level_id, ['LVL250101002', 'LVL250101003']);
        });

        Gate::define('isAdminAndKoor', function ($user) {
            return in_array($user->user_level_id, ['LVL250101001', 'LVL241223002']);
        });

        Gate::define('isNocAndKoor', function ($user) {
            return in_array($user->user_level_id, ['LVL250101002', 'LVL241223002']);
        });

        Gate::define('isSalesAndKoor', function ($user) {
            return in_array($user->user_level_id, ['LVL250101003', 'LVL241223002']);
        });

        Gate::define('isAdminAndNocAndSales', function ($user) {
            return in_array($user->user_level_id, ['LVL250101001', 'LVL250101002', 'LVL250101003']);
        });

        Gate::define('isAdminAndNocAndKoor', function ($user) {
            return in_array($user->user_level_id, ['LVL250101001', 'LVL250101002', 'LVL241223002']);
        });

        Gate::define('isAdminAndSalesAndKoor', function ($user) {
            return in_array($user->user_level_id, ['LVL250101001', 'LVL250101003', 'LVL241223002']);
        });

        Gate::define('isNocAndSalesAndKoor', function ($user) {
            return in_array($user->user_level_id, ['LVL250101002', 'LVL250101003', 'LVL241223002']);
        });

        Gate::define('isAllLevels', function ($user) {
            $allowedLevels = ['LVL250101001', 'LVL250101002', 'LVL250101003', 'LVL241223002'];
            return in_array($user->user_level_id, $allowedLevels);
        });
    }

}
