<?php

namespace paulmillband\cachedImageResizer\App\Http\Controllers;
use Illuminate\Routing\Controller;
use paulmillband\cachedImageResizer\App\Models\Crop\CropperReformatCache;
use paulmillband\cachedImageResizer\App\Models\Crop\ImageCropper;

class CropperReformatController extends Controller
{
    protected $resizeCacheClass;

    public function __construct()
    {
        $this->resizeCacheClass = new CropperReformatCache();
    }

    /**
     * @param string $format
     * @param int $width
     * @param int $height
     * @param string $imgCode
     * @param string $extension
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \ImagickException
     */
    protected function resizeCropAndReformat(
        string $format,
        int $width,
        int $height,
        string $imgCode,
        string $extension
    ){
        $newPath = $this->resizeCacheClass->newFilePath($imgCode, $format, $extension, $width, $height);
        $img = preg_replace('/-([a-zA-Z]*)$/','.$1', $imgCode);
        ImageCropper::resizeAndCropIfNeeded(
            public_path('images/'.$img),
            $newPath,
            $format,
            -1,
            -1,
            $width,
            $height
        );
        return response()->file($newPath);
    }

}
