<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// Untuk Passport:
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [

    ];

    public function boot(): void
    {
        $this->registerPolicies();
        Passport::routes();
    }
}
