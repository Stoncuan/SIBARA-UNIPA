<?php

namespace App\Providers;

use App\Service\Impl\PinjamanBarangServiceImpl;
use App\Service\PinjamanBarangService;
use Illuminate\Support\ServiceProvider;

class PinjamanBarangServiceProvider extends ServiceProvider
{
    public array $singletons = [
        PinjamanBarangService::class => PinjamanBarangServiceImpl::class
    ];

    public function provides()
    {
        return [PinjamanBarangService::class];
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
