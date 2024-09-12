<?php
namespace paulmillband\cachedImageResizer\App\Models\Crop;

use Imagick;
use paulmillband\cachedImageResizer\App\Models\Resize\Resize;

class Crop
{
    /**
     * @param string $imageFilePath
     * @param string $resizedFilePath
     * @param string $requiredFileType
     * @param int $xCoordinate
     * @param int $yCoordinate
     * @param int $width
     * @param int $height
     * @param int $filterType
     * @param float $blur
     * @param bool $bestFit
     * @return bool
     * @throws \ImagickException
     */
    static function resizeAndCrop(
        string $imageFilePath,
        string $resizedFilePath,
        string $requiredFileType='',
        int $xCoordinate=-1,
        int $yCoordinate=-1,
        int $width=0,
        int $height=0,
        int $filterType=Imagick::FILTER_CATROM,
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
        $resizeDimensions = self::getDimensionsToCreateResizeImageBeforeItsCropped($imagick, $width, $height);
        if($xCoordinate==-1){
            $xCoordinate=self::getCoordinateForCentredImage($resizeDimensions['w'], $width);
        }
        if($yCoordinate==-1){
            $yCoordinate=self::getCoordinateForCentredImage($resizeDimensions['h'], $height);
        }
        self::resizeAndCropAction(
            $imagick,
            $requiredFileType,
            $resizeDimensions['w'],
            $resizeDimensions['h'],
            $resizedFilePath,
            $xCoordinate,
            $yCoordinate,
            $width,
            $height,
            $filterType,
            $blur,
            $bestFit
        );
        return true;
    }

    /**
     * @param Imagick $imagick
     * @param int $width
     * @param int $height
     * @return array
     */
    private static function getDimensionsToCreateResizeImageBeforeItsCropped(Imagick $imagick, int $width, int $height){
        $resizeHeight = Resize::getResizedHeight($imagick, $width);
        if($resizeHeight >= $height){
            $resizeWidth = $width;
        }else{
            $resizeWidth = Resize::getResizedWidth($imagick, $height);
            $resizeHeight = $height;
        }
        return [
            'h'=>$resizeHeight,
            'w'=>$resizeWidth
        ];
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

    /**
     * @param Imagick $imagick
     * @param string $requiredFileType
     * @param int $resizeWidth
     * @param int $resizeHeight
     * @param string $resizedFilePath
     * @param int $xCoordinate
     * @param int $yCoordinate
     * @param int $width
     * @param int $height
     * @param int $filterType
     * @param float $blur
     * @param bool $bestFit
     */
    protected static function resizeAndCropAction(
        Imagick $imagick,
        string $requiredFileType,
        int $resizeWidth,
        int $resizeHeight,
        string $resizedFilePath,
        int $xCoordinate=-1,
        int $yCoordinate=-1,
        int $width=0,
        int $height=0,
        int $filterType=Imagick::FILTER_CATROM,
        float $blur=1,
        bool $bestFit=false
    ){
        $imagick->resizeImage($resizeWidth, $resizeHeight, $filterType, $blur, $bestFit);
        $imagick->cropImage($width,$height, $xCoordinate, $yCoordinate);
        if($requiredFileType){
            $imagick->setImageFormat($requiredFileType);
        }
        $imagick->writeImage($resizedFilePath);
        $imagick->clear();
        $imagick->destroy();
    }

}
