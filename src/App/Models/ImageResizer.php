<?php
namespace paulmillband\cachedImageResizer\App\Models;

use Imagick;
use paulmillband\cachedImageResizer\App\Models\Image;
use paulmillband\cachedImageResizer\App\Models\Resize;
use function PHPUnit\Framework\directoryExists;

class ImageResizer
{
    /**
     * @param string $imageFilePath
     * @param string $resizedCacheFolderPath
     * @param int $width set to 0 to automaticall calculate
     * @param int $height set to 0 to automaticall calculate
     * @param int $filterType
     * @param float $blur The blur factor where > 1 is blurry, < 1 is sharp
     * @param bool $bestFit
     * @return string resized image url
     * creates a resized copy of an image into a folder named as the width value, inside the cache folder given
     */
    static function resizeIfNeeded(
        string $imageFilePath,
        string $resizedCacheFolderPath,
        int $width,
        int $height = 0,
        int $filterType = Imagick::FILTER_CATROM,
        float $blur = 1,
        bool $bestFit = false
    ) {
        if(!is_dir($resizedCacheFolderPath)){
            mkdir($resizedCacheFolderPath, 0775, true);
        }
        $newPath = $resizedCacheFolderPath.'/'.$imageFilePath;
        if(!file_exists($newPath)){
            Resize::resize(
                $imageFilePath,
                $newPath,
                $width,
                $height,
                $filterType,
                $blur,
                $bestFit
            );
        }
//        return (new Image($newPath))->getUrl();
        return $newPath;
    }
}
