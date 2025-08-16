<?php

namespace App\Providers;

use App\Service\AuthService;
use App\Service\Impl\AuthServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        AuthService::class => AuthServiceImpl::class
    ];

    public function provides(){
        return [AuthService::class];
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
