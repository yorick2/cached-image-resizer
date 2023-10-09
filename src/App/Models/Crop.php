<?php
namespace paulmillband\cachedImageResizer\App\Models;

use Imagick;
use paulmillband\cachedImageResizer\App\Models\Resize;

class crop
{
    /**
    * @param string $imageFilePath
    * @param string $resizedFilePath
    * @param int $width set to 0 to automaticall calculate
    * @param int $height set to 0 to automaticall calculate$height
    * @param int $x The X coordinate of the cropped region's top left corner or 0 for center
    * @param int $y The Y coordinate of the cropped region's top left corner or 0 for center
    * @return bool
    * @throws \ImagickException
    * creates a cropped of an image
    */
    static function crop(
        string $imageFilePath,
        string $resizedFilePath,
        int $width,
        int $height = 0,
        int $x=0,
        int $y=0
    ) {
        $file = realpath($imageFilePath);
        if($file===false){
            return false;
        }
        $imagick = new Imagick($file);
        if($height == 0){
            $height = Resize::getResizedHeight($imagick, $width);
        }
        if($width == 0){
            $width = Resize::getResizedWidth($imagick, $height);
        }
        if($x==0){
            $x=self::getXCoordinateForCentredImage($imagick, $width);
        }
        if($y==0){
            $y=self::getYCoordinateForCentredImage($imagick, $height);
        }
        $imagick->cropImage($width,$height, $x, $y);
        $imagick->writeImage($resizedFilePath);
        $imagick->clear();
        $imagick->destroy();
        return true;
    }

    /**
     * @param Imagick $imagick
     * @param int $newWidth
     * @return int
     */
    public static function getXCoordinateForCentredImage(Imagick $imagick, int $newWidth){
        $sizeDifference = $imagick->getImageWidth() - $newWidth;
        return round($sizeDifference / 2);
    }

    /**
     * @param Imagick $imagick
     * @param int $newHeight
     * @return float
     */
    public static function getYCoordinateForCentredImage(Imagick $imagick, int $newHeight){
        $sizeDifference = $imagick->getImageHeight() - $newHeight;
        return round($sizeDifference / 2);
    }

}
