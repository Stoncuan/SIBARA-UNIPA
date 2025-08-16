<?php

namespace App\Providers;

use App\Service\AdminService;
use App\Service\Impl\AdminServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        AdminService::class => AdminServiceImpl::class
    ];

    public function provides(){
        return [AdminService::class];
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
