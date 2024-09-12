<?php

namespace paulmillband\cachedImageResizer\App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use paulmillband\cachedImageResizer\App\Models\Helper\ImageFormats;
use paulmillband\cachedImageResizer\App\Models\Reformat\ImageReformater;
use paulmillband\cachedImageResizer\App\Models\Reformat\ReformatCache;

class ReformaterController extends Controller
{
    protected $reformatCacheClass;

    public function __construct()
    {
        $this->reformatCacheClass = new ReformatCache();
    }

    /**
     * @param Request $request
     * @param int $width
     * @param int $height
     * @param string $imgPath
     * @param string $extension
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \ImagickException
     */
    protected function resizeAndReformat(
        Request $request,
        int $width,
        int $height,
        string $imgPath,
        string $extension
    ){
        $format = ImageFormats::getImageFormatFromExtension($extension);
        $newPath = $this->reformatCacheClass->newFilePath($imgPath, $format, $extension, $width, $height);
        ImageReformater::resizeAndReformatIfNeeded(
            public_path('images/'.$imgPath),
            $newPath,
            $format,
            $width,
            $height
        );
//        header("Content-type: image/".$format);
        return response()->file($newPath);
    }

}
