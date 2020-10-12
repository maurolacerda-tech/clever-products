<?php

namespace Modules\Products\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ProductServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::namespace('Modules\Products\Http\Controllers')
            ->middleware(['web'])
            ->group(__DIR__. '/../Routes/web.php');

            $this->loadViewsFrom(__DIR__.'/../Views', 'Product');

            $this->loadMigrationsFrom(__DIR__.'/../Migrations');

            $this->publishes([
                __DIR__.'/../Views' => resource_path('views/vendor/Product'),
            ], 'views');

            
            $this->publishes([
                __DIR__.'/../Config/products.php' => config_path('products.php'),
            ], 'config');
            
    }
    public function register()
    {        
        $this->mergeConfigFrom(
            __DIR__.'/../Config/products.php',
            'products'
        );
        
    }
}