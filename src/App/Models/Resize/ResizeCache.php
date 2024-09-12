<?php
namespace paulmillband\cachedImageResizer\App\Models\Resize;

use paulmillband\cachedImageResizer\App\Models\Helper\ImageCacheFolderPath;

class ResizeCache
{
    private string $cacheFolderPath;

    public function __construct()
    {
        $this->cacheFolderPath = ImageCacheFolderPath::getImageCacheFolderPath();
        $this->cacheFolderRelativePath = ImageCacheFolderPath::getRelativeImageCacheFolderPath();
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
