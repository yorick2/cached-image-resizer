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

    public function resizeToWidth(Request $request, int $width, string $imgPath)
    {
        $newPath = $this->resizedCacheFolder.'/width/'.$width.'/'.$imgPath;
        ImageResizer::resizeIfNeeded(
            public_path('images/'.$imgPath),
            $newPath,
            $width
        );
        return response()->file($newPath);
    }

    public function resizeToHeight(Request $request, int $height, string $imgPath)
    {
        $newPath = $this->resizedCacheFolder.'/height/'.$height.'/'.$imgPath;
        ImageResizer::resizeIfNeeded(
            public_path('images/'.$imgPath),
            $newPath,
            0,
            $height
        );
        return response()->file($newPath);
    }
}
