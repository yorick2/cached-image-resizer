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

    protected function canCropAndConvertImageFileFormats(
        string $originalFilePath,
        string $newFormat,
        string $newFileExtension,
        int $width=0,
        int $height=0
    ){
        $originalFileRelativePath = str_replace(public_path('images').'/','',$originalFilePath);
        $newImageFilePath = $this->cropperReformatCache->newFilePath($originalFileRelativePath, ImageFormats::getImageFormatFromExtension($newFileExtension), $newFileExtension, $width, $height);
        $this->assertFileDoesNotExist($newImageFilePath);
        $response = $this->get(route('pm-image-cropper-converter', [
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

}
