<?php
namespace paulmillband\cachedImageResizer\App\Models\Crop;

use Imagick;
use paulmillband\cachedImageResizer\App\Models\Resize\Resize;

class Crop
{
    /**
     * @param string $imageFilePath
     * @param string $resizedFilePath
     * @param int $xCoordinate The X coordinate of the cropped region's top left corner or -1 for center
     * @param int $yCoordinate The Y coordinate of the cropped region's top left corner or -1 for center
     * @param int $width set to 0 to automatically calculate
     * @param int $height set to 0 to automatically calculate
     * @param int $filterType
     * @param float $blur
     * @param bool $bestFit
     * @return bool
     * @throws \ImagickException
     */
    static function resizeAndCrop(
        string $imageFilePath,
        string $resizedFilePath,
        int $xCoordinate=-1,
        int $yCoordinate=-1,
        int $width=0,
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
        if($width == 0){
            $width = $imagick->getImageWidth();
        }
        if($height == 0){
            $height = $imagick->getImageHeight();
        }
        $resizeHeight = Resize::getResizedHeight($imagick, $width);
        if($resizeHeight >= $height){
            $resizeWidth = $width;
        }else{
            $resizeWidth = Resize::getResizedWidth($imagick, $height);
            $resizeHeight = $height;
        }
        if($xCoordinate==-1){
            $xCoordinate=self::getCoordinateForCentredImage($resizeWidth, $width);
        }
        if($yCoordinate==-1){
            $yCoordinate=self::getCoordinateForCentredImage($resizeHeight, $height);
        }
        $imagick->resizeImage($resizeWidth, $resizeHeight, $filterType, $blur, $bestFit);
        $imagick->cropImage($width,$height, $xCoordinate, $yCoordinate);
        $imagick->writeImage($resizedFilePath);
        $imagick->clear();
        $imagick->destroy();
        return true;
    }

    /**
     * @param int $originalLength
     * @param int $newLength
     * @return float
     */
    public static function getCoordinateForCentredImage(int $originalLength, int $newLength){
        $sizeDifference = $originalLength - $newLength;
        return round($sizeDifference / 2);
    }

}