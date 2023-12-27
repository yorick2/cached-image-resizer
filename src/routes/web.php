<?php

use paulmillband\cachedImageResizer\App\Http\Controllers\CropperController;
use paulmillband\cachedImageResizer\App\Http\Controllers\CropperReformatController;
use paulmillband\cachedImageResizer\App\Http\Controllers\ReformaterController;
use paulmillband\cachedImageResizer\App\Http\Controllers\ResizerController;

Route::get('/pm-image-resizer/w/{width}/h/{height}/{img?}',
    [ResizerController::class, 'resize']
)
    ->name('pm-image-resizer')
    ->where('img', '(.*)');

Route::get(
    '/pm-image-resizer/converted/{format}/w/{width}/h/{height}/{imgcode}.{extension?}',
    [ReformaterController::class, 'resizeAndReformat']
)
    ->name('pm-image-converter')
    ->where('imgcode', '([^.]*)');

Route::get(
    '/pm-image-resizer/cropped/w/{width}/h/{height}/{img?}',
    [CropperController::class, 'resizeAndCrop']
)
    ->name('pm-image-cropper')
    ->where('img', '(.*)');

Route::get(
    '/pm-image-resizer/cropped/converted/{format}/w/{width}/h/{height}/{imgcode}.{extension?}',
    [CropperReformatController::class, 'resizeCropAndReformat']
)
    ->name('pm-image-cropper-converter')
    ->where('imgcode', '([^.]*)');


