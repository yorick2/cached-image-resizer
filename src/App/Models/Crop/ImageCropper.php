<?php
namespace paulmillband\cachedImageResizer\App\Models\Crop;

class ImageCropper
{
    /**
     * @param string $imageFilePath
     * @param string $newPath
     * @param int $width set to 0 to automaticall calculate
     * @param int $height set to 0 to automaticall calculate
     * @param int $xCoord
     * @param int $yCoord
     * @return bool
     * @throws \ImagickException
     */
    static function cropIfNeeded(
        string $imageFilePath,
        string $newPath,
        int $width,
        int $height=0,
        int $xCoord=0,
        int $yCoord=0
    ) {
        $newFileDirname = dirname($newPath);
        if(!is_dir($newFileDirname)){
            mkdir($newFileDirname, 0775, true);
        }
        if(!file_exists($newPath)){
            $success = Crop::crop(
                $imageFilePath,
                $newPath,
                $width,
                $height,
                $xCoord,
                $yCoord
            );
            if($success === false){
                return false;
            }
        }
        return true;
    }
}
