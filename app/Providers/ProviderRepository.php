<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ProviderRepository extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            'App\Interface\Product\ProductInterface',
            'App\Interface\Product\ProductRepository'
        );
        $this->app->bind(
            'App\Interface\Client\ClientInterface',
            'App\Interface\Client\ClientRepository'
        );
        $this->app->bind(
            'App\Interface\Invoice\InvoiceInterface',
            'App\Interface\Invoice\InvoiceRepository'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
