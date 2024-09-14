<?php

namespace Tests\Feature;

use paulmillband\cachedImageResizer\App\Models\Resize\ImageResizer;
use paulmillband\cachedImageResizer\App\Models\Resize\ResizeCache;
use Tests\ImageTestImageLocations;
use Tests\TestCase;

class ImageResizerTest extends TestCase
{
    use ImageTestImageLocations;
    use ImageTestSetVariablesTrait;
    use ImageTestFilesTrait;
    use ImageTestsTrait;

    private $imageResizer;
    private $resizeCacheClass;
    private string $cacheFolderPath;

    public function setUp(): void
    {
        parent::setUp();
        $this->resizeCacheClass = new ResizeCache();
        $this->imageResizer = ImageResizer::class;
        if(!$this->setClassVariables("/Resize([A-Za-z]*)Image/")){
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
     * @return string
     */
    protected function canResize(
        int $width,
        int $height,
        string $imagePath,
        string $format,
        bool $fileShouldAlreadyExist=false
    ) {
        $imagePath = '/'.ltrim($imagePath, '/');
        $newImageFilePath = $this->resizeCacheClass->newFilePath($width, $height, $imagePath);
        $this->ImageCreationGetRequestSuccess(
            route('pm-image-resizer', [
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
        return $newImageFilePath;
    }

    public function test_canResizeJpgImageByWidth()
    {
        $this->canResize(
            100,
            0,
            $this->jpgImageSubPath,
            'JPEG'
        );
    }

    public function test_canResizeJpgImageByHeight()
    {
        $this->canResize(
            0,
            100,
            $this->jpgImageSubPath,
            'JPEG'
        );
    }

    public function test_canResizePngImageByWidth()
    {
        $this->canResize(
            100,
            0,
            $this->pngImageSubPath,
            'PNG'
        );
    }

    public function test_canResizePngImageByHeight()
    {
        $this->canResize(
            0,
            100,
            $this->pngImageSubPath,
            'PNG'
        );
    }

    public function test_canUseCachedResizeJpgImage()
    {
        $filePath1 = $this->canResize(
            100,
            0,
            $this->jpgImageSubPath,
            'JPEG'
        );
        sleep(2);
        $secondRequestTime = time();
        $filePath2 = $this->canResize(
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
