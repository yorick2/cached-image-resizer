<?php
namespace paulmillband\cachedImageResizer\App\Models\Crop;

use paulmillband\cachedImageResizer\App\Models\Helper\ImageCacheFolderPath;

class CropperReformatCache
{
    private string $cacheFolderPath;

    public function __construct()
    {
        $this->cacheFolderPath = ImageCacheFolderPath::getImageCacheFolderPath().'/cropped';
    }

    /**
     * @param string $imagePath
     * @param string $format
     * @param string $fileExtension
     * @param int $width
     * @param int $height
     * @return string
     */
    public function newFilePath(string $imagePath, string $format, string $fileExtension, int $width, int $height)
    {
        $baseName = basename($imagePath);
        $folder = $this->cacheFolderPath.'/'.$format.'/w/'.$width.'/h/'.$height.'/'.dirname($imagePath).'/'
            .str_replace('.', '-', $baseName);
        return $folder.'/'.preg_replace('/\.[^.]*$/', '.'.$fileExtension, $baseName);
    }

}
