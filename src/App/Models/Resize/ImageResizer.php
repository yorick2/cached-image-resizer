<?php
namespace paulmillband\cachedImageResizer\App\Models\Resize;

use Imagick;

class ImageResizer
{
    /**
     * @param string $imageFilePath
     * @param string $newPath
     * @param int $width set to 0 to automatically calculate
     * @param int $height set to 0 to automatically calculate
     * @param int $filterType
     * @param float $blur The blur factor where > 1 is blurry, < 1 is sharp
     * @param bool $bestFit
     * @return bool|string resized image url
     * @throws \ImagickException
     * creates a resized copy of an image into a folder named as the width value, inside the cache folder given
     */
    static function resizeIfNeeded(
        string $imageFilePath,
        string $newPath,
        int $width,
        int $height = 0,
        int $filterType = Imagick::FILTER_CATROM,
        float $blur = 1,
        bool $bestFit = false
    ) {
        $newFileDirname = dirname($newPath);
        if(!is_dir($newFileDirname)){
            mkdir($newFileDirname, 0775, true);
        }
        if(!file_exists($newPath)){
            $success = Resize::resize(
                $imageFilePath,
                $newPath,
                $width,
                $height,
                $filterType,
                $blur,
                $bestFit
            );
            if($success === false){
                return false;
            }
        }
        return true;
    }
}
