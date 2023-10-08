<?php

namespace paulmillband\cachedImageResizer\App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
        $cacheFolder = $this->resizedCacheFolder.'/width/'.$width.'/'.dirname($imgPath);
        $newPath = ImageResizer::resizeIfNeeded(
            public_path('images/'.$imgPath),
            $cacheFolder,
            $width
        );
        return response()->file($newPath);
    }

    public function resizeToHeight(Request $request, $height, $imgPath)
    {
        $cacheFolder = $this->resizedCacheFolder.'/height/'.$height.'/'.dirname($imgPath);
        $newPath = ImageResizer::resizeIfNeeded(
            public_path('images/'.$imgPath),
            $cacheFolder,
            0,
            $height
        );
        return response()->file($newPath);
    }
}
