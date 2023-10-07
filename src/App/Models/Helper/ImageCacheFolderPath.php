<?php

namespace paulmillband\cachedImageResizer\App\Models\Helper;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class ImageCacheFolderPath extends Model
{
    /**
     * @return string
     */
    public static function getRelativeImageCacheFolderPath()
    {
        if(env('IMAGE_CACHE_FOLDER')){
            return env('IMAGE_CACHE_FOLDER');
        }
        return '/images/cache';
    }

    /**
     * @return string
     */
    public static function getImageCacheFolderPath()
    {
        return public_path().'/'.self::getRelativeImageCacheFolderPath();
    }

    /**
     * @return string
     */
    public static function getImageCacheFolderUrl()
    {
        return URL::to(self::getRelativeImageCacheFolderPath());
    }

}
