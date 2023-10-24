<?php

namespace paulmillband\cachedImageResizer\App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use paulmillband\cachedImageResizer\App\Models\Resize\ImageResizer;
use paulmillband\cachedImageResizer\App\Models\Resize\ResizeCache;

class ResizerController extends Controller
{
    protected $resizeCacheClass;

    public function __construct()
    {
        $this->resizeCacheClass = new ResizeCache();
    }

    /**
     * @param int $width
     * @param int $height
     * @param string $imgPath
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \ImagickException
     */
    protected function resize(int $width, int $height, string $imgPath){
        $newPath = $this->resizeCacheClass->newFilePath($width, $height, $imgPath);
        ImageResizer::resizeIfNeeded(
            public_path('images/'.$imgPath),
            $newPath,
            $width,
            $height
        );
        return response()->file($newPath);
    }

    /**
     * @param int $width
     * @param int $height
     * @param string $imgPath
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \ImagickException
     */
    protected function resizeAndReformat(int $width, int $height, string $imgPath){
        $newPath = $this->resizeCacheClass->newFilePath($width, $height, $imgPath);
        ImageResizer::resizeIfNeeded(
            public_path('images/'.$imgPath),
            $newPath,
            $width,
            $height
        );
        return response()->file($newPath);
    }

}
