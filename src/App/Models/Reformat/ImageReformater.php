<?php
namespace paulmillband\cachedImageResizer\App\Models\Reformat;

use Imagick;

class ImageReformater
{
    /**
     * @param string $imageFilePath
     * @param string $newPath
     * @param string $requiredFileType
     * @param int $width
     * @param int $height
     * @return bool|string
     * @throws \ImagickException
     * creates a copy of an image in a new image format e.g. jpg > png
     */
    static function reformatIfNeeded(
        string $imageFilePath,
        string $newPath,
        string $requiredFileType,
        int $width=0,
        int $height=0
    ) {
        $dirname = dirname($newPath);
        if(!is_dir($dirname)){
            mkdir($dirname, 0775, true);
        }
        if(!file_exists($newPath)){
            $success = Reformat::reformat(
                $imageFilePath,
                $newPath,
                $requiredFileType,
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
