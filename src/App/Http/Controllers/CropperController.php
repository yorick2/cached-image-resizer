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
     * @param Request $request
     * @param int $width
     * @param int $height
     * @param string $imgPath
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \ImagickException
     */
    protected function resizeAndCrop(
        Request $request,
        int $width,
        int $height,
        string $imgPath
    ){
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
