<?php

namespace App\Providers;

use App\Models\Siswa;
use App\Models\User;
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

        Gate::define('user_all', function ($user) {
            $allowedRoles = ['Guru', 'Admin', 'Super Admin', 'Siswa'];
            return in_array($user->hakAkses, $allowedRoles);
        });
        Gate::define('super.admin', function ($user) {
            return $user->hakAkses == 'Super Admin';
        });
        Gate::define('admin', function ($user) {
            return $user->hakAkses == 'Admin';
        });
        Gate::define('guru', function ($user) {
            return $user->hakAkses == 'Guru';
        });
        Gate::define('siswa', function ($user) {
            return $user->hakAkses == 'Siswa';
        });
    }
}
