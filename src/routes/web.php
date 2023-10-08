<?php

use paulmillband\cachedImageResizer\App\Http\Controllers\ResizerController;

Route::get('/', function () {
    return "testing page loaded";
});

Route::get('/pm-image-resizer/w/{width}/{img?}', [ResizerController::class, 'resizeToWidth'])
    ->name('image-resizer')
    ->where('img', '(.*)');

Route::get('/pm-image-resizer/h/{height}/{img?}', [ResizerController::class, 'resizeToHeight'])
    ->name('image-resizer')
    ->where('img', '(.*)');


