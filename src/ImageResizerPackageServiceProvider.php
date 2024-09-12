<?php

namespace paulmillband\cachedImageResizer;

use Illuminate\Support\ServiceProvider;

class ImageResizerPackageServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/App/Http/Controllers/PaulMillband/CacheImageResizer/ResizerController.php' =>
                app_path('Http/Controllers/PaulMillband/CacheImageResizer/ResizerController.php')
        ]);
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        if (\App::environment('testing')) {
            $this->loadRoutesFrom(__DIR__ . '/routes/testing.php');
        }
    }
}
