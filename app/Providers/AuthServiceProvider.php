<?php

namespace App\Providers;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        $gate->define('isAdmin', function($user){
            return $user->role == 'Admin';
        });
        $gate->define('isOwner', function($user){
            return $user->role == 'Owner';
        });
        $gate->define('isTanent', function($user){
            return $user->role == 'Tanent';
        });
        $gate->define('isDeveloper', function($user){
            return $user->role == 'Developer';
        });
        $gate->define('isSecurtiy', function($user){
            return $user->role == 'Security';
        });

        //
    }
}
