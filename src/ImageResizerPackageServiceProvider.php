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
        $this->publishes(
            [
                __DIR__ . '/resources/js/Components/Picture.vue' =>
                    resource_path('resources/js/Components/Picture.vue')
            ],
            'vue-components');
        $this->publishes(
            [
                __DIR__ . '/app/Http/Controllers/PaulMillband/CacheImageResizer/ResizerController.php' =>
                    app_path('Http/Controllers/PaulMillband/CacheImageResizer/ResizerController.php')
            ]);
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }
}
