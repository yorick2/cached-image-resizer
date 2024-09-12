<?php

use paulmillband\cachedImageResizer\App\Http\Controllers\CropperController;
use paulmillband\cachedImageResizer\App\Http\Controllers\CropperReformatController;
use paulmillband\cachedImageResizer\App\Http\Controllers\ReformaterController;
use paulmillband\cachedImageResizer\App\Http\Controllers\ResizerController;
use paulmillband\cachedImageResizer\App\Http\Controllers\TestPageController;

Route::get('/', function () {
    return "testing page loaded";
});
