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
                __DIR__ . '/../resources/js/Components/PMImageResizer' =>
                    resource_path('resources/js/Components/imageResizer')
            ],
            'vue-components');
        //
    }
}
