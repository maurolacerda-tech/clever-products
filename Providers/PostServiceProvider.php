<?php

namespace Modules\Posts\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class PostServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::namespace('Modules\Posts\Http\Controllers')
            ->middleware(['web'])
            ->group(__DIR__. '/../Routes/web.php');

            $this->loadViewsFrom(__DIR__.'/../Views', 'Post');

            $this->loadMigrationsFrom(__DIR__.'/../Migrations');

            $this->publishes([
                __DIR__.'/../Views' => resource_path('views/vendor/Post'),
            ], 'views');

            
            $this->publishes([
                __DIR__.'/../Config/posts.php' => config_path('posts.php'),
            ], 'config');
            
    }
    public function register()
    {        
        $this->mergeConfigFrom(
            __DIR__.'/../Config/posts.php',
            'posts'
        );
        
    }
}