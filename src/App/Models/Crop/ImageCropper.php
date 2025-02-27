<?php
namespace paulmillband\cachedImageResizer\App\Models\Crop;

use paulmillband\cachedImageResizer\App\Models\Resize\ImageResizer;
use paulmillband\cachedImageResizer\App\Models\Resize\Resize;

class ImageCropper
{
    /**
     * @param string $imageFilePath
     * @param string $newPath
     * @param string $requiredFileType
     * @param int $xCoordinate The X coordinate of the cropped region's top left corner or -1 for center
     * @param int $yCoordinate The Y coordinate of the cropped region's top left corner or -1 for center
     * @param int $width set to 0 to automatically calculate
     * @param int $height set to 0 to automatically calculate
     * @return bool
     * @throws \ImagickException
     */
    static function resizeAndCropIfNeeded(
        string $imageFilePath,
        string $newPath,
        string $requiredFileType='',
        int $xCoordinate=-1,
        int $yCoordinate=-1,
        int $width=0,
        int $height=0
    ) {
        if($width == 0 || $height == 0){
            return ImageResizer::resizeIfNeeded(
                $imageFilePath,
                $newPath,
                $width,
                $height,
            );
        }
        $newFileDirname = dirname($newPath);
        if(!is_dir($newFileDirname)){
            mkdir($newFileDirname, 0775, true);
        }
        if(!file_exists($newPath)){
            $success = Crop::resizeAndCrop(
                $imageFilePath,
                $newPath,
                $requiredFileType,
                $xCoordinate,
                $yCoordinate,
                $width,
                $height
            );
            if($success === false){
                return false;
            }
        }
        return true;
    }
}
