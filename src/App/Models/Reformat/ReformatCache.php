<?php
namespace paulmillband\cachedImageResizer\App\Models\Reformat;

use paulmillband\cachedImageResizer\App\Models\Helper\ImageCacheFolderPath;

class ReformatCache
{
    private string $cacheFolderPath;

    public function __construct()
    {
        $this->cacheFolderPath = ImageCacheFolderPath::getImageCacheFolderPath();
    }

    public function newFilePath(string $imagePath, string $format, string $fileExtension, int $width=0, int $height=0)
    {
        $baseName = basename($imagePath);
        $folder = $this->cacheFolderPath.'/'.$format.'/w/'.$width.'/h/'.$height.'/'.dirname($imagePath).'/'
            .str_replace('.', '-', $baseName);
        return $folder.'/'.preg_replace('/\.[^.]*$/', '.'.$fileExtension, $baseName);
    }
}
