<?php

namespace App\Providers;

<<<<<<< HEAD
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
=======
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67

class AuthServiceProvider extends ServiceProvider
{
    /**
<<<<<<< HEAD
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
=======
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
    ];

    /**
     * Register any authentication / authorization services.
<<<<<<< HEAD
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

=======
     */
    public function boot(): void
    {
>>>>>>> df8fd1e0a75bf37a3f73aca1da97278d268a4c67
        //
    }
}
