<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use paulmillband\cachedImageResizer\App\Models\ImageResizer;
use Tests\TestCase;
use Imagick;

class ImageResizerTest extends TestCase
{
    const IMAGE_LOCATION_JPG = __DIR__.'/../../testImages/pexels-craig-dennis-205421-400X266.jpg';
    const IMAGE_LOCATION_PNG = __DIR__.'/../../testImages/pexels-craig-dennis-205421-400X266.png';
    private $imageResizer;

    public function __construct(string $name = null, array $data = [], $dataName = '')
    {
        $this->imageResizer = ImageResizer::class;
        parent::__construct($name, $data, $dataName);
    }

    /** @test */
    public function visit_test_route()
    {
        // Visit /test and see "Test Laravel package isolated" on it
        $response = $this->get('');
        $response->assertStatus(200);
        $response->assertSee('Test Laravel package isolated');
    }

    public function test_canResizeJpgImage()
    {
        $cacheFolder = public_path('images/cache');
        $imgFolder = public_path('images/test/');
        $imgPath = $imgFolder.basename(self::IMAGE_LOCATION_JPG);
        $resizedImgURl = URL::to('/pm-image-resizer/w/100/test'.basename(self::IMAGE_LOCATION_JPG));
        if(!is_dir($imgFolder)){
            mkdir($imgFolder, 0775, true);
        }
        $copySuccess = copy(
            self::IMAGE_LOCATION_JPG,
            $imgPath
        );
        $this->assertTrue($copySuccess, 'Test image could not be copied into place to prepare for test');
        if(file_exists($cacheFolder.'/*')){
            unlink($cacheFolder.'/*');
        }
        $response = $this->get($resizedImgURl);
        $response->assertStatus( 200);

//        $this->imageResizer::resizeIfNeeded(
//            realpath(self::IMAGE_LOCATION_JPG),
//            realpath($cacheFolder),
//            300
//        );
//        $imageFilePath = realpath(__DIR__.'/../../testImages/cache').'/'.basename(self::IMAGE_LOCATION_JPG);
//        $imagick = new Imagick($imageFilePath);
//        $this->assertEquals($imagick->getImageWidth(), 300);
//        $this->assertEquals($imagick->getImageHeight(), 200);
//        $imagick->destroy();
    }


}
