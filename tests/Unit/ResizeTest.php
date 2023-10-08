<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\Resize;
use PhpParser\Node\Scalar\MagicConst\Dir;
use Tests\TestCase;
use Imagick;

class ResizeTest extends TestCase
{
    const IMAGE_LOCATION_JPG = __DIR__.'/../../testImages/pexels-craig-dennis-205421-400X266.jpg';
    const IMAGE_LOCATION_PNG = __DIR__.'/../../testImages/pexels-craig-dennis-205421-400X266.png';
    private $cacheFolderPath = __DIR__.'/../../testImages/cache';
    private $imageClass;

    public function __construct(string $name = null, array $data = [], $dataName = '')
    {
        $this->imageClass = Resize::class;
        parent::__construct($name, $data, $dataName);
    }

    public function setUp(): void
    {
        parent::setUp();
        $files = glob($this->cacheFolderPath.'/*'); // get all file names
        foreach($files as $file){
            if(is_file($file)) {
                unlink($file);
            }
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $files = glob($this->cacheFolderPath.'/*'); // get all file names
        foreach($files as $file){
            if(is_file($file)) {
                unlink($file);
            }
        }
    }

    public function test_canResizeImage()
    {
        $this->imageClass::resize( self::IMAGE_LOCATION_JPG, __DIR__.'/../../testImages/cache/'.basename(self::IMAGE_LOCATION_JPG), 300);
        $imageFilePath = realpath($this->cacheFolderPath).'/'.basename(self::IMAGE_LOCATION_JPG);
        $imagick = new Imagick($imageFilePath);
        $this->assertEquals($imagick->getImageWidth(), 300);
        $this->assertEquals($imagick->getImageHeight(), 200);
        $imagick->destroy();
    }

}
