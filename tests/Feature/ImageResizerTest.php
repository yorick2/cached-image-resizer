<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\URL;
use paulmillband\cachedImageResizer\App\Models\Resize\ImageResizer;
use paulmillband\cachedImageResizer\App\Models\Resize\ResizeCache;
use Tests\ImageTestImageLocations;
use Tests\TestCase;
use Imagick;

class ImageResizerTest extends TestCase
{
    use ImageTestImageLocations;
    use ImageTestSetVariablesTrait;
    use ImageTestFilesTrait;

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
     * @param int $imageConstant
     * @param string $filetype
     */
    protected function canResize(int $width, int $height, string $imagePath, int $imageConstant, string $filetype)
    {
        $imagePath = '/'.ltrim($imagePath, '/');
        $cachedImagePath = $this->resizeCacheClass->newFilePath($width, $height, $imagePath);
        $this->assertFileDoesNotExist($cachedImagePath);
        $response = $this->get(route('pm-image-resizer', [
            'width' => $width,
            'height' => $height,
            'imgPath' => $imagePath
        ]));
        $response->assertStatus( 200);
        $this->assertFileExists($cachedImagePath);
        $imageSize = getimagesize($cachedImagePath);
        if($width){
            $this->assertTrue(($imageSize[0] == 100), 'cached image not required width');
        }else{
            $this->assertTrue(($imageSize[0] > 1 ), 'cached image not required width');
        }
        if ($height){
            $this->assertTrue($imageSize[2] === $imageConstant, 'cached image isn\'t a '.$filetype);
        }else{
            $this->assertTrue($imageSize[2] > 1, 'cached image isn\'t a '.$filetype);
        }
    }

    public function test_canResizeJpgImageByWidth()
    {
        $this->canResize( 100,  0,  $this->jpgImageSubPath,  IMAGETYPE_JPEG,  'jpg');
    }

    public function test_canResizeJpgImageByHeight()
    {
        $this->canResize( 0,  100,  $this->jpgImageSubPath,  IMAGETYPE_JPEG,  'jpg');
    }

    public function test_canResizePngImageByWidth()
    {
        $this->canResize( 100,  0,  $this->pngImageSubPath,  IMAGETYPE_PNG,  'png');
    }

    public function test_canResizePngImageByHeight()
    {$this->canResize( 0,  100,  $this->pngImageSubPath,  IMAGETYPE_PNG,  'png');
    }
}
