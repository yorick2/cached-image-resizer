<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\URL;
use paulmillband\cachedImageResizer\App\Models\Helper\ImageFormats;
use paulmillband\cachedImageResizer\App\Models\Reformat\ReformatCache;
use Tests\ImageTestImageLocations;
use Tests\TestCase;

use Imagick;

class ImageReformaterTest extends TestCase
{
    use ImageTestImageLocations;
    use ImageTestSetVariablesTrait;
    use ImageTestFilesTrait;
    use ImageTestsTrait;

    private $reformatCacheClass;

    public function setUp(): void
    {
        parent::setUp();
        $this->reformatCacheClass = new ReformatCache();
        if(!$this->setClassVariables("/From([A-Za-z]*)To/")){
            return;
        }
        $this->setUpImages($this->{$this->imageFileType.'ModuleImagePath'}, $this->laravelImageFolder.'/'.$this->{$this->imageFileType.'ImageSubPath'});
    }

    /**
     * @param string $originalFilePath
     * @param string $newFormat
     * @param string $newFileExtension
     * @param int $width
     * @param int $height
     * @param bool $fileShouldAlreadyExist
     * @return string filepath of created file
     * @throws \ImagickException
     */
    protected function canConvertImageFileFormats(
        string $originalFilePath,
        string $newFormat,
        string $newFileExtension,
        int $width=0,
        int $height=0,
        bool $fileShouldAlreadyExist=false
    ){
        $originalFileRelativePath = str_replace(public_path('images').'/','',$originalFilePath);
        $newImageFilePath = $this->reformatCacheClass->newFilePath(
            $originalFileRelativePath,
            ImageFormats::getImageFormatFromExtension($newFileExtension),
            $newFileExtension,
            $width,
            $height
        );
        $route = route('pm-image-converter', [
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

    public function test_canConvertImageFileFormatsFromWebpToJpg()
    {
        $this->canConvertImageFileFormats(
            $this->webpLaravelImagePath,
            'JPEG',
            'jpg'
        );
    }

    public function test_canConvertImageFileFormatsFromWebpToPng()
    {
        $this->canConvertImageFileFormats(
            $this->webpLaravelImagePath,
            'PNG',
            'png'
        );
    }


    public function test_canConvertImageFileFormatsFromSvgToJpg()
    {
        $this->canConvertImageFileFormats(
            $this->svgLaravelImagePath,
            'JPEG',
            'jpg',
            200,
            133
        );
    }

    public function test_canConvertImageFileFormatsFromSvgToWebp()
    {
        $this->canConvertImageFileFormats(
            $this->svgLaravelImagePath,
            'WEBP',
            'webp',
            200,
            133
        );
    }

    public function test_canConvertImageFileFormatsFromSvgToPng()
    {
        $this->canConvertImageFileFormats(
            $this->svgLaravelImagePath,
            'WEBP',
            'webp',
            200,
            133
        );
    }

    public function test_canConvertImageFileFormatsFromSvgWithTransparencyToPng()
    {
        $this->canConvertImageFileFormats(
            $this->svgWithTransparencyLaravelImagePath,
            'PNG',
            'png',
            200,
            133
        );
    }

    public function test_canUseImageCacheConvertedFromWebpToJpg()
    {
        $filePath1 = $this->canConvertImageFileFormats(
            $this->webpLaravelImagePath,
            'JPEG',
            'jpg'
        );
        sleep(2);
        $secondRequestTime = time();
        $filePath2 = $this->canConvertImageFileFormats(
            $this->webpLaravelImagePath,
            'JPEG',
            'jpg',
            0,
            0,
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
