<?php

use paulmillband\cachedImageResizer\App\Http\Controllers\CropperController;
use paulmillband\cachedImageResizer\App\Http\Controllers\CropperReformatController;
use paulmillband\cachedImageResizer\App\Http\Controllers\ReformaterController;
use paulmillband\cachedImageResizer\App\Http\Controllers\ResizerController;

Route::get('/pm-image-resizer/w/{width}/h/{height}/{imgPath}',
    [ResizerController::class, 'resize']
)
    ->name('pm-image-resizer')
    ->where('imgPath', '.*');

Route::get(
    '/pm-image-resizer/converted/w/{width}/h/{height}/{imgPath}.{extension}',
    [ReformaterController::class, 'resizeAndReformat']
)
    ->name('pm-image-converter')
    ->where('imgPath', '.*');

Route::get(
    '/pm-image-resizer/cropped/w/{width}/h/{height}/{imgPath}',
    [CropperController::class, 'resizeAndCrop']
)
    ->name('pm-image-cropper')
    ->where('imgPath', '.*');

Route::get(
    '/pm-image-resizer/cropped/converted/w/{width}/h/{height}/{imgPath}.{extension}',
    [CropperReformatController::class, 'resizeCropAndReformat']
)
    ->name('pm-image-cropper-converter')
    ->where('imgPath','.*');


