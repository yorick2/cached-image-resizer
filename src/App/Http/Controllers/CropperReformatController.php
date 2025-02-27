<?php

namespace paulmillband\cachedImageResizer\App\Http\Controllers;
use Illuminate\Routing\Controller;
use paulmillband\cachedImageResizer\App\Models\Crop\CropperReformatCache;
use paulmillband\cachedImageResizer\App\Models\Crop\ImageCropper;
use paulmillband\cachedImageResizer\App\Models\Helper\ImageFormats;
use paulmillband\cachedImageResizer\App\Models\Reformat\ImageReformater;

class CropperReformatController extends Controller
{
    protected $resizeCacheClass;

    public function __construct()
    {
        $this->resizeCacheClass = new CropperReformatCache();
    }

    /**
     * @param string $imgPath
     * @param string $extension
     * @param int $width
     * @param int $height
     * @param int $xCoordinate
     * @param int $yCoordinate
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \ImagickException
     */
    protected function resizeCropAndReformat(
        int $width,
        int $height,
        string $imgPath,
        string $extension,
        int $xCoordinate=-1,
        int $yCoordinate=-1
    ){
        $format = ImageFormats::getImageFormatFromExtension($extension);
        $newPath = $this->resizeCacheClass->newFilePath($imgPath, $format, $extension, $width, $height);
        ImageCropper::resizeAndCropIfNeeded(
            public_path('images/'.$imgPath),
            $newPath,
            $format,
            $xCoordinate,
            $yCoordinate,
            $width,
            $height
        );
        return response()->file($newPath);
    }

}
