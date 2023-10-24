<?php
namespace paulmillband\cachedImageResizer\App\Models\Resize;

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
     * @param bool $bestFit
     * @return bool
     * @throws \ImagickException
     * creates a resized copy of an image
     */
    static function resize(
        string $imageFilePath,
        string $resizedFilePath,
        int $width,
        int $height=0,
        int $filterType = Imagick::FILTER_CATROM,
        float $blur=1,
        bool $bestFit=false
    ) {
        $file = realpath($imageFilePath);
        if($file===false){
            return false;
        }
        $imagick = new Imagick($file);
        if($height == 0){
            $height = self::getResizedHeight($imagick, $width);
        }
        if($width == 0){
            $width = self::getResizedWidth($imagick, $height);
        }
        $imagick->resizeImage($width, $height, $filterType, $blur, $bestFit);
        $imagick->writeImage($resizedFilePath);
        $imagick->clear();
        $imagick->destroy();
        return true;
    }

    /**
     * @param Imagick $imagickImage
     * @param int $resizedWidth
     * @return float
     */
    static function getResizedHeight(Imagick $imagickImage, int $resizedWidth){
        $ratio = $resizedWidth / $imagickImage->getImageWidth();
        return ceil($ratio * $imagickImage->getImageHeight());
    }

    /**
     * @param Imagick $imagickImage
     * @param int $resizedHeight
     * @return float
     */
    static function getResizedWidth(Imagick $imagickImage, int $resizedHeight){
        $ratio = $resizedHeight / $imagickImage->getImageHeight();
        return ceil($ratio * $imagickImage->getImageWidth());
    }

}
