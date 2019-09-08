<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\User;

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

        Gate::define('see-price', function (?User $user, $object) {
            if ($object->price_admins_only || $object->object_admins_only) {
                if (!$user || !$user->isAdminGroup()) return false;
            }
            if ($object->only_auth) {
                if (!$user || !$user->isAccepted()) return false;
            }
            return true;
        });
        Gate::define('see-description', function (?User $user, $object) {
            if ($object->only_auth) {
                if (!$user || !$user->isAccepted()) return false;
            }
            if ($object->object_admins_only) {
                if (!$user || !$user->isAdminGroup()) return false;
            }
            return true;
        });
        Gate::define('get-docs', function (?User $user, $object) {
            if ($object->only_auth) {
                if (!$user || !$user->isAccepted()) return false;
            }
            if ($object->object_admins_only) {
                if (!$user || !$user->isAdminGroup()) return false;
            }
            return true;
        });
    }
}
