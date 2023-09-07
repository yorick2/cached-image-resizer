<?php
namespace paulmillband\cachedImageResizer;

use Imagick;

class Resize
{
    /**
     * @param int $width set to 0 to automaticall calculate
     * @param int $height set to 0 to automaticall calculate
     * @param $filterType
     * @param $blur The blur factor where > 1 is blurry, < 1 is sharp
     * @param $bestFit
     * @param $cropZoom
     * creates a resized copy of an image
     */
    static function resize(
        string $imageFilePath,
        string $resizedFilePath,
        int $width,
        int $height = 0,
        int $filterType = Imagick::FILTER_CATROM,
        float $blur = 1,
        bool $bestFit = false
    ) {
        $imagick = new Imagick(realpath($imageFilePath));
        if($height == 0){
            $height = self::getResizedHeight($imagick, $width);
        }
        if($width == 0){
            $width = self::getResizedWidth($imagick, $height);
        }
        $imagick->resizeImage($width, $height, $filterType, $blur, $bestFit);
        $imagick->writeImage($resizedFilePath);
        $imagick->destroy();
    }

    /**
     * @param Imagick $imagick
     * @param $resizedWidth
     * @return float
     */
    static function getResizedHeight(Imagick $imagick, $resizedWidth){
        $ratio = $resizedWidth / $imagick->getImageWidth();
        return ceil($ratio * $imagick->getImageHeight());
    }

    /**
     * @param Imagick $imagick
     * @param $resizedHeight
     * @return float
     */
    static function getResizedWidth(Imagick $imagick, $resizedHeight){
        $ratio = $resizedHeight / $imagick->getImageHeight();
        return ceil($ratio * $imagick->getImageWidth());
    }

}
