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

    protected function canConvertImageFileFormats(
        string $originalFilePath,
        string $newFormat,
        string $newFileExtension,
        int $width=0,
        int $height=0
    ){
        $originalFileRelativePath = str_replace(public_path('images'),'',$originalFilePath);
        $newImageFilePath = $this->reformatCacheClass->newFilePath($originalFileRelativePath, ImageFormats::getImageFormatFromExtension($newFileExtension), $newFileExtension, $width, $height);
        $this->assertFileDoesNotExist($newImageFilePath);
        $response = $this->get(route('pm-image-converter', [
            'width' => $width,
            'height' => $height,
            'imgPath' => $originalFileRelativePath,
            'extension' => $newFileExtension
        ]));
        $response->assertStatus( 200);
        sleep(0.5);
        $this->assertFileExists($newImageFilePath);

        $oldImagick = new Imagick($originalFilePath);
        $newImagick = new Imagick($newImageFilePath);
        if($width==0){
            $width = $oldImagick->getImageWidth();
        }
        if($height==0){
            $height = $oldImagick->getImageHeight();
        }
        $this->assertEquals($newImagick->getImageWidth(), $width);
        $this->assertEquals($newImagick->getImageHeight(), $height);
        $this->assertTrue($newImagick->getImageFormat() === $newFormat, 'cached image isn\'t a '.$newFormat);
        $oldImagick->clear();
        $oldImagick->destroy();
        $newImagick->clear();
        $newImagick->destroy();
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
            'PNG',
            'png',
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

}
