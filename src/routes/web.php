<?php

use paulmillband\cachedImageResizer\App\Http\Controllers\PaulMillband\CacheImageResizer\ResizerController;

Route::get('/pm-image-resizer/{img?}', [ResizerController::class, 'show'])
    ->name('image-resizer')
    ->where('img', '(.*)');
