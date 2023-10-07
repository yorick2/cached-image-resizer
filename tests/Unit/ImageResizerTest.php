<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\ImageResizer;
use PHPUnit\Framework\TestCase;
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

    public function test_canResizeImage()
    {
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['HTTP_HOST'] = 'dev.laravel';
        $_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__.'/../../');
        $this->imageResizer::resizeIfNeeded(
            self::IMAGE_LOCATION_JPG,
            realpath(__DIR__.'/../../testImages/cache'),
            300
        );
        $imageFilePath = realpath(__DIR__.'/../../testImages/cache').'/'.basename(self::IMAGE_LOCATION_JPG);
        $imagick = new Imagick($imageFilePath);
        $this->assertEquals($imagick->getImageWidth(), 300);
        $this->assertEquals($imagick->getImageHeight(), 200);
        $imagick->destroy();
    }

//    public function test_CanGetResizedImageUrl(){
//        $_SERVER['HTTPS'] = 'on';
//        $_SERVER['HTTP_HOST'] = 'dev.laravel';
//        $_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__.'/../../');
//        $url = $this->imageResizer::resizeIfNeeded(
//            self::IMAGE_LOCATION_JPG,
//            __DIR__.'/../../testImages/cache/'
//            , 300);
//        $this->assertEquals($url,
//            'https://'.$_SERVER['HTTP_HOST'].'/testImages/cache/300/pexels-craig-dennis-205421-400X266.jpg');
//
//    }

    public function test_canSwitchImageFileFormats()
    {
        $this->assertTrue(false);
    }

    public function test_canCropImage()
    {
        $this->assertTrue(false);
    }

    public function test_canReturnAnImageInAGivenAspectRatio()
    {
        $this->assertTrue(false);
    }

}
