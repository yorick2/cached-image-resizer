<?php
namespace paulmillband\cachedImageResizer\App\Models\Crop;

use paulmillband\cachedImageResizer\App\Models\Helper\ImageCacheFolderPath;

class CropperCache
{
    private string $cacheFolderPath;

    public function __construct()
    {
        $this->cacheFolderPath = ImageCacheFolderPath::getImageCacheFolderPath();
    }

    /**
     * @param int $width
     * @param int $height
     * @param string $imgPath
     * @return string
     */
    public function newFilePath(int $width, int $height, string $imgPath)
    {
        if($height == 0){
            return $this->cacheFolderPath.'/width/'.$width.'/'.$imgPath;
        }
        if($width == 0){
            return $this->cacheFolderPath.'/height/'.$height.'/'.$imgPath;
        }
        return $this->cacheFolderPath.'/width/'.$width.'/height/'.$height.'/'.$imgPath;
    }
}
