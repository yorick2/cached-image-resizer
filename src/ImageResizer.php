<?php
namespace paulmillband\cachedImageResizer;

use Imagick;
use \paulmillband\cachedImageResizer\Image;
use \paulmillband\cachedImageResizer\Resize;
use function PHPUnit\Framework\directoryExists;

class ImageResizer
{
    /**
     * @param string $imageFilePath
     * @param string $resizedFilePath
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
        string $resizedCacheFolder,
        int $width,
        int $height = 0,
        int $filterType = Imagick::FILTER_CATROM,
        float $blur = 1,
        bool $bestFit = false

    ) {
        $cacheFolder = $resizedCacheFolder."/${width}/";
        if(!is_dir($cacheFolder)){
            mkdir($cacheFolder, 0775);
        }
        $newPath = $cacheFolder.basename($imageFilePath);
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
        return (new Image($newPath))->getUrl();
    }
}
