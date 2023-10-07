<?php
namespace paulmillband\cachedImageResizer\App\Models;

use Imagick;

class Resize
{
    /**
     * @param string $imageFilePath
     * @param string $resizedFilePath
     * @param int $width set to 0 to automaticall calculate
     * @param int $height set to 0 to automaticall calculate
     * @param $filterType
     * @param float $blur The blur factor where > 1 is blurry, < 1 is sharp
     * @param boolean$bestFit
     * @throws [\ImagickException]
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
     * @param Imagick $imagickImage
     * @param $resizedWidth
     * @return float
     */
    static function getResizedHeight(Imagick $imagickImage, $resizedWidth){
        $ratio = $resizedWidth / $imagickImage->getImageWidth();
        return ceil($ratio * $imagickImage->getImageHeight());
    }

    /**
     * @param Imagick $imagickImage
     * @param $resizedHeight
     * @return float
     */
    static function getResizedWidth(Imagick $imagickImage, $resizedHeight){
        $ratio = $resizedHeight / $imagickImage->getImageHeight();
        return ceil($ratio * $imagickImage->getImageWidth());
    }

}
