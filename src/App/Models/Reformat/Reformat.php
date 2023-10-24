<?php
namespace paulmillband\cachedImageResizer\App\Models\Reformat;

use paulmillband\cachedImageResizer\App\Models\Resize\Resize;
use Imagick;
use ImagickPixel;

class Reformat
{
    /**
    * @param string $originalFilePath
    * @param string $newFilePath
    * @param string $requiredFileType
    * @param int $width
    * @param int $height
    * @return bool
    * @throws \ImagickException
    * creates a copy of an image in a different format
    */
    public static function resizeAndReformat(
        string $originalFilePath,
        string $newFilePath,
        string $requiredFileType,
        int $width=0,
        int $height=0
    ) {
        $file = realpath($originalFilePath);
        if($file===false){
            return false;
        }
        if($width==0 && $height==0){
            self::simpleReformat($originalFilePath,  $newFilePath,  $requiredFileType);
            return true;
        }
        self::reformatAndResize(
            $originalFilePath,
            $newFilePath,
            $requiredFileType,
            $width,
            $height
        );
        return true;
    }

    protected static function simpleReformat(string $originalFilePath, string $newFilePath, string $requiredFileType){
        $imagick = new Imagick($originalFilePath);
        $imagick->setImageFormat($requiredFileType);
        $imagick->writeImage($newFilePath);
        $imagick->clear();
        $imagick->destroy();
    }

    protected static function reformatAndResize(
        string $originalFilePath,
        string $newFilePath,
        string $requiredFileType,
        int $width=0,
        int $height=0,
        int $filterType = Imagick::FILTER_CATROM,
        float $blur = 1,
        bool $bestFit = false
    ){
        $imagick = new Imagick($originalFilePath);
        if($height == 0){
            $height = Resize::getResizedHeight($imagick, $width);
        }
        if($width == 0){
            $width = Resize::getResizedWidth($imagick, $height);
        }
        $imagick->clear();
        $imagick->destroy();
        $imagick = new Imagick($originalFilePath);
        $imagick->resizeImage($width, $height, $filterType, $blur, $bestFit);
        $imagick->setImageFormat($requiredFileType);
        $imagick->writeImage($newFilePath);
        $imagick->clear();
        $imagick->destroy();
    }
}
