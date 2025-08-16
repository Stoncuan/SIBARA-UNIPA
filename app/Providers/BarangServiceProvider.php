<?php

namespace App\Providers;

use App\Service\BarangService;
use App\Service\Impl\BarangServiceImpl;
use Illuminate\Support\ServiceProvider;

class BarangServiceProvider extends ServiceProvider
{
    public array $singletons = [
        BarangService::class => BarangServiceImpl::class
    ];

    public function provides(){
        return [BarangService::class];
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
