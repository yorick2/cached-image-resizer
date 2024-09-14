<?php

namespace Tests\Feature;

use paulmillband\cachedImageResizer\App\Models\Crop\CropperCache;
use paulmillband\cachedImageResizer\App\Models\Crop\ImageCropper;
use Tests\ImageTestImageLocations;
use Tests\TestCase;
use Imagick;

class ImageCropperTest extends TestCase
{
    use ImageTestImageLocations;
    use ImageTestSetVariablesTrait;
    use ImageTestFilesTrait;
    use ImageTestsTrait;

    private $imageCropper;
    private $CropperCacheClass;
    private string $cacheFolderPath;

    public function setUp(): void
    {
        parent::setUp();
        $this->CropperCacheClass = new CropperCache();
        $this->imageCropper = ImageCropper::class;
        if(!$this->setClassVariables("/Crop([A-Za-z]*)Image/")){
            return;
        };
        $this->setUpImages(
            $this->{$this->imageFileType.'ModuleImagePath'},
            $this->laravelImageFolder.'/'.$this->{$this->imageFileType.'ImageSubPath'}
        );
    }

    /** @test */
    public function test_canVisitTestRoute()
    {
        $response = $this->call('GET', '/');
        $response->assertStatus(200);
        $response->assertSee('testing page loaded');
    }

    /**
     * @param int $width
     * @param int $height
     * @param string $imagePath
     * @param string $format
     * @param bool $fileShouldAlreadyExist
     * @return string filepath of created file
     * @throws \ImagickException
     */
    protected function canCrop(
        int $width,
        int $height,
        string $imagePath,
        string $format,
        bool $fileShouldAlreadyExist=false
    ){
        $imagePath = '/'.ltrim($imagePath, '/');
        $newImageFilePath = $this->CropperCacheClass->newFilePath($width, $height, $imagePath);
        $this->ImageCreationGetRequestSuccess(
            route('pm-image-cropper', [
                'width' => $width,
                'height' => $height,
                'imgPath' => $imagePath
            ]),
            $newImageFilePath,
            $format,
            $width,
            $height,
            $fileShouldAlreadyExist
        );
        $imagick = new Imagick($newImageFilePath);
        if($width){
            $this->assertEquals($imagick->getImageWidth(), $width);
        }
        if($height){
            $this->assertEquals($imagick->getImageHeight(), $height);
        }
        $imagick->clear();
        $imagick->destroy();
        return $newImageFilePath;
    }

    public function test_canCropJpgImageByWidth()
    {
        $this->canCrop(
            100,
            0,
            $this->jpgImageSubPath,
            'JPEG'
        );
    }

    public function test_canCropJpgImageByHeight()
    {
        $this->canCrop(
            0,
            100,
            $this->jpgImageSubPath,
            'JPEG'
        );
    }

    public function test_canCropJpgImageByWidthAndHeight()
    {
        $this->canCrop(
            100,
            100,
            $this->jpgImageSubPath,
            'JPEG'
        );
    }

    public function test_canCropPngImageByWidth()
    {
        $this->canCrop(
            100,
            0,
            $this->pngImageSubPath,
            'PNG'
        );
    }

    public function test_canCropPngImageByHeight()
    {
        $this->canCrop(
            0,
            100,
            $this->pngImageSubPath,
            'PNG'
        );
    }

    public function test_canCropPngImageByWidthAndHeight()
    {
        $this->canCrop(
            100,
            100,
            $this->pngImageSubPath,
            'PNG'
        );
    }

    public function test_canUseCropJpgImageFromCache()
    {
        $filePath1 = $this->canCrop(
            100,
            0,
            $this->jpgImageSubPath,
            'JPEG'
        );
        sleep(2);
        $secondRequestTime = time();
        $filePath2 = $this->canCrop(
                100,
                0,
                $this->jpgImageSubPath,
                'JPEG',
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
