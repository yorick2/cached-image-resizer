<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\URL;
use paulmillband\cachedImageResizer\App\Models\ImageResizer;
use Tests\TestCase;
use Imagick;

class ImageResizerTest extends TestCase
{
    const IMAGE_LOCATION_JPG = __DIR__.'/../../testImages/pexels-craig-dennis-205421-400X266.jpg';
    const IMAGE_LOCATION_PNG = __DIR__.'/../../testImages/pexels-craig-dennis-205421-400X266.png';
    private $imageResizer;
    private string $cacheFolderPath;
    private string $jpgImageSubPath;
    private string $jpgImagePath;
    private string $jpgImgFolderPath;
    private string $pngImageSubPath;
    private string $pngImagePath;
    private string $pngImgFolderPath;

    public function __construct(string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->imageResizer = ImageResizer::class;

        $this->cacheFolderPath = public_path('images/cache/');
        $files = glob($this->cacheFolderPath."/*/*/*/*");
        foreach($files as $file){
            if(is_file($file)) {
                unlink($file);
            }
        }

        $this->jpgImageSubPath = '/test/'.basename(self::IMAGE_LOCATION_JPG);
        $this->jpgImagePath = public_path('images'.$this->jpgImageSubPath);
        $this->jpgImgFolderPath = dirname($this->jpgImagePath);
        if(!is_dir($this->jpgImgFolderPath)){
            mkdir($this->jpgImgFolderPath, 0775, true);
        }
        $copySuccess = copy(
            self::IMAGE_LOCATION_JPG,
            $this->jpgImagePath
        );
        $this->assertTrue($copySuccess, 'Test image could not be copied into place to prepare for test');

        $this->pngImageSubPath = '/test/'.basename(self::IMAGE_LOCATION_PNG);
        $this->pngImagePath = public_path('images'.$this->pngImageSubPath);
        $this->pngImgFolderPath = dirname($this->pngImagePath);
        if(!is_dir($this->pngImgFolderPath)){
            mkdir($this->pngImgFolderPath, 0775, true);
        }
        $copySuccess = copy(
            self::IMAGE_LOCATION_PNG,
            $this->pngImagePath
        );
        $this->assertTrue($copySuccess, 'Test image could not be copied into place to prepare for test');

    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $files = glob($this->cacheFolderPath."/*/*/*/*");
        foreach($files as $file){
            if(is_file($file)) {
                unlink($file);
            }
        }
        if(file_exists($this->jpgImagePath)){
            unlink($this->jpgImagePath);
        }
        if(file_exists($this->pngImagePath)){
            unlink($this->pngImagePath);
        }
    }

    /** @test */
    public function visit_test_route()
    {
        $response = $this->call('GET', '/');
        $response->assertStatus(200);
        $response->assertSee('testing page loaded');
    }

    public function test_canResizeJpgImageByWidth()
    {
        $resizedImageURL = URL::to('/pm-image-resizer/w/100'.$this->jpgImageSubPath);
         $response = $this->get($resizedImageURL);
        $response->assertStatus( 200);
        $cachedImagePath = $this->cacheFolderPath.'/width/100/'.$this->jpgImageSubPath;
        $this->assertFileExists($cachedImagePath);
        $imageSize = getimagesize($cachedImagePath);
        $this->assertTrue(($imageSize[0] == 100), 'cached image not required width');
        $this->assertTrue(($imageSize[1] > 1), 'cached image not required height');
        $this->assertTrue($imageSize[2] === IMAGETYPE_JPEG, 'cached image isn\'t a jpg');
    }

    public function test_canResizeJpgImageByHeight()
    {
        $resizedImageURL = URL::to('/pm-image-resizer/h/100'.$this->jpgImageSubPath);
        $response = $this->get($resizedImageURL);
        $response->assertStatus( 200);
        $cachedImagePath = $this->cacheFolderPath.'/height/100/'.$this->jpgImageSubPath;
        $this->assertFileExists($cachedImagePath);
        $imageSize = getimagesize($cachedImagePath);
        $this->assertTrue(($imageSize[0] > 1), 'cached image not required width');
        $this->assertTrue(($imageSize[1] == 100), 'cached image not required height');
        $this->assertTrue($imageSize[2] === IMAGETYPE_JPEG, 'cached image isn\'t a jpg');
    }

    public function test_canResizePngImageByWidth()
    {
        $resizedImageURL = URL::to('/pm-image-resizer/w/100'.$this->pngImageSubPath);
        $response = $this->get($resizedImageURL);
        $response->assertStatus( 200);
        $cachedImagePath = $this->cacheFolderPath.'/width/100/'.$this->pngImageSubPath;
        $this->assertFileExists($cachedImagePath);
        $imageSize = getimagesize($cachedImagePath);
        $this->assertTrue(($imageSize[0] == 100), 'cached image not required width');
        $this->assertTrue(($imageSize[1] > 1), 'cached image not required height');
        $this->assertTrue($imageSize[2] === IMAGETYPE_PNG, 'cached image isn\'t a png');
    }

    public function test_canResizePngImageByHeight()
    {
        $resizedImageURL = URL::to('/pm-image-resizer/h/100'.$this->pngImageSubPath);
        $response = $this->get($resizedImageURL);
        $response->assertStatus( 200);
        $cachedImagePath = $this->cacheFolderPath.'/height/100/'.$this->pngImageSubPath;
        $this->assertFileExists($cachedImagePath);
        $imageSize = getimagesize($cachedImagePath);
        $this->assertTrue(($imageSize[0] > 1), 'cached image not required width');
        $this->assertTrue(($imageSize[1] == 100), 'cached image not required height');
        $this->assertTrue($imageSize[2] === IMAGETYPE_PNG, 'cached image isn\'t a png');
    }
}
