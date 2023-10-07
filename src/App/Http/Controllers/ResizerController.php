<?php

namespace paulmillband\cachedImageResizer\App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use paulmillband\cachedImageResizer\App\Models\Helper\ImageCacheFolderPath;
use paulmillband\cachedImageResizer\App\Models\ImageResizer;

class ResizerController extends Controller
{
    protected $resizedCacheFolder;

    public function __construct()
    {
        $this->resizedCacheFolder = ImageCacheFolderPath::getImageCacheFolderPath();
    }

    public function resizeToWidth(Request $request, $width, $imgPath)
    {
        return response()->setContent('booo');
        $cacheFolder = $this->resizedCacheFolder.'/width/'.$width;
        $newPath = ImageResizer::resizeIfNeeded(
            $imgPath,
            $cacheFolder,
            $width
        );
        return response()->file($newPath);
    }

    public function resizeToHeight(Request $request, $height, $imgPath)
    {
        xdebug_enable();
        $cacheFolder = $this->resizedCacheFolder.'/height/'.$height;
        $newPath = ImageResizer::resizeIfNeeded(
            $imgPath,
            $cacheFolder,
            0,
            $height
        );
        return response()->file($newPath);
    }
}
