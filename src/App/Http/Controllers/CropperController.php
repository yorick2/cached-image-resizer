<?php

namespace paulmillband\cachedImageResizer\App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use paulmillband\cachedImageResizer\App\Models\Crop\CropperCache;
use paulmillband\cachedImageResizer\App\Models\Crop\ImageCropper;

class CropperController extends Controller
{
    protected $resizeCacheClass;

    public function __construct()
    {
        $this->resizeCacheClass = new CropperCache();
    }

    /**
     * crops from center of image if needed
     * @param int $width set to 0 to automatically calculate
     * @param int $height set to 0 to automatically calculate
     * @param string $imgPath
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \ImagickException
     */
    protected function resizeAndCrop( int $width, int $height, string $imgPath){
        $newPath = $this->resizeCacheClass->newFilePath($width, $height, $imgPath);
        ImageCropper::resizeAndCropIfNeeded(
            public_path('images/'.$imgPath),
            $newPath,
            '',
            -1,
            -1,
            $width,
            $height
        );
        return response()->file($newPath);
    }

}
