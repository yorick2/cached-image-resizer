<?php

namespace paulmillband\cachedImageResizer\App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
     * @param string $imgcode
     * @param int $width
     * @param int $height
     * @param string $format
     */
    protected function resizeAndReformat(
        Request $request,
        string $format,
        int $width,
        int $height,
        string $imgcode,
        string $extension
    ){
        $newPath = $this->reformatCacheClass->newFilePath($imgcode, $format, $extension, $width, $height);
        $img = preg_replace('/-([a-zA-Z]*)$/','.$1', $imgcode);
        ImageReformater::resizeAndReformatIfNeeded(
            public_path('images/'.$img),
            $newPath,
            $format,
            $width,
            $height
        );
//        header("Content-type: image/".$format);
        return response()->file($newPath);
    }

}
