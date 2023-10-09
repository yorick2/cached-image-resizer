<?php

namespace paulmillband\cachedImageResizer\App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use paulmillband\cachedImageResizer\App\Models\Helper\ImageCacheFolderPath;
use paulmillband\cachedImageResizer\App\Models\ImageReformater;
use paulmillband\cachedImageResizer\App\Models\ImageResizer;

class ReformaterController extends Controller
{
    protected $resizedCacheFolder;

    public function __construct()
    {
        $this->resizedCacheFolder = ImageCacheFolderPath::getImageCacheFolderPath();
    }

    public function reformat(Request $request, string $imgPath, string $requiredFileType)
    {
        $cacheFolder = $this->resizedCacheFolder.'/'.dirname($imgPath);
        $baseName = basename($imgPath);
        $newPath = $cacheFolder.'/'.replace($baseName, '.', '-').
            '/'.preg_replace($baseName, '\.[^.]*$', '.'.$requiredFileType);
        ImageReformater::reformatIfNeeded(
            public_path('images/'.$imgPath),
            $cacheFolder,
            $requiredFileType,
            $newPath
        );
        header("Content-type: image/".$requiredFileType);
        return response()->file($newPath);
    }

}
