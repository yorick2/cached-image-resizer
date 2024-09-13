<?php

namespace Tests\Feature;

use paulmillband\cachedImageResizer\App\Models\Crop\CropperReformatCache;
use paulmillband\cachedImageResizer\App\Models\Helper\ImageFormats;
use Tests\ImageTestImageLocations;
use Tests\TestCase;
use Imagick;

class ImageCropperReformaterTest extends TestCase
{
    use ImageTestImageLocations;
    use ImageTestSetVariablesTrait;
    use ImageTestFilesTrait;
    use ImageTestsTrait;

    private $cropperReformatCache;

    public function setUp(): void
    {
        parent::setUp();
        $this->cropperReformatCache = new CropperReformatCache();
        if(!$this->setClassVariables("/From([A-Za-z]*)To/")){
            return;
        }
        $this->setUpImages(
            $this->{$this->imageFileType.'ModuleImagePath'},
            $this->laravelImageFolder.'/'.$this->{$this->imageFileType.'ImageSubPath'}
        );
    }

    /**
     * @param string $originalFilePath
     * @param string $newFormat
     * @param string $newFileExtension
     * @param int $width
     * @param int $height
     * @param bool $fileShouldAlreadyExist
     * @return string new file path
     * @throws \ImagickException
     */
    protected function canCropAndConvertImageFileFormats(
        string $originalFilePath,
        string $newFormat,
        string $newFileExtension,
        int $width=0,
        int $height=0,
        bool $fileShouldAlreadyExist=false
    ){
        $originalFileRelativePath = str_replace(public_path('images').'/','',$originalFilePath);
        $newImageFilePath = $this->cropperReformatCache->newFilePath(
            $originalFileRelativePath,
            ImageFormats::getImageFormatFromExtension($newFileExtension),
            $newFileExtension,
            $width,
            $height
        );
        $route = route('pm-image-cropper-converter', [
            'width' => $width,
            'height' => $height,
            'imgPath' => $originalFileRelativePath,
            'extension' => $newFileExtension
        ]);
        $oldImagick = new Imagick($originalFilePath);
        if($width==0){
            $width = $oldImagick->getImageWidth();
        }
        if($height==0){
            $height = $oldImagick->getImageHeight();
        }
        $oldImagick->clear();
        $oldImagick->destroy();
        $this->ImageCreationSuccess(
            $route,
            $newImageFilePath,
            $newFormat,
            $width,
            $height,
            $fileShouldAlreadyExist
        );
        return $newImageFilePath;
    }

    public function test_canConvertImageFileFormatsFromSvgToJpg()
    {
        $this->canCropAndConvertImageFileFormats(
            $this->svgLaravelImagePath,
            'JPEG',
            'jpg',
            200,
            133
        );
    }

    public function test_canConvertImageFileFormatsFromSvgToWebp()
    {
        $this->canCropAndConvertImageFileFormats(
            $this->svgLaravelImagePath,
            'WEBP',
            'webp',
            200,
            133
        );
    }

    public function test_canConvertImageFileFormatsFromSvgToPng()
    {
        $this->canCropAndConvertImageFileFormats(
            $this->svgLaravelImagePath,
            'PNG',
            'png',
            200,
            133
        );
    }

    public function test_canConvertImageFileFormatsFromSvgWithTransparencyToPng()
    {
        $this->canCropAndConvertImageFileFormats(
            $this->svgWithTransparencyLaravelImagePath,
            'PNG',
            'png',
            200,
            133
        );
    }

    public function test_canUseImageCacheConvertedFromSvgToJpg()
    {
        $filePath1 = $this->canCropAndConvertImageFileFormats(
            $this->svgLaravelImagePath,
            'JPEG',
            'jpg',
            200,
            133
        );
        sleep(2);
        $secondRequestTime = time();
        $filePath2 = $this->canCropAndConvertImageFileFormats(
            $this->svgLaravelImagePath,
            'JPEG',
            'jpg',
            200,
            133,
            true
        );
        $this->assertEquals($filePath1, $filePath2);
        clearstatcache();
        $this->assertTrue(
            filemtime($filePath2) < $secondRequestTime-1,
            'file recreated, cache file not used'
        );
    }
}
