<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\Resize;
use PhpParser\Node\Scalar\MagicConst\Dir;
use Tests\TestCase;
use Imagick;

class ResizeTest extends TestCase
{
    const IMAGE_LOCATION_JPG = __DIR__.'/../../testImages/laptop-400X266.jpg';
    const IMAGE_LOCATION_PNG = __DIR__.'/../../testImages/laptop-400X266.png';
    const IMAGE_LOCATION_WEBP = __DIR__.'/../../testImages/laptop-400X266.webp';
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

    protected function canResize(string $filePath, string $format, int $width, int $height)
    {
        $this->imageClass::resize( $filePath, __DIR__.'/../../testImages/cache/'.basename($filePath), $width);
        $imageFilePath = realpath($this->cacheFolderPath).'/'.basename($filePath);
        $imagick = new Imagick($imageFilePath);
        $this->assertEquals($imagick->getImageWidth(), $width);
        $this->assertEquals($imagick->getImageHeight(), $height);
        $this->assertTrue($imagick->getImageFormat() === $format, 'cached image isn\'t a '.$format);
        $imagick->clear();
        $imagick->destroy();
    }

    public function test_canResizeJpgImage()
    {
        $this->canResize(self::IMAGE_LOCATION_JPG, 'JPEG', 300, 200);
    }

    public function test_canResizePngImage()
    {
        $this->canResize(self::IMAGE_LOCATION_PNG, 'PNG', 300, 200);
    }

    public function test_canResizeWebpImage()
    {
        $this->canResize(self::IMAGE_LOCATION_WEBP, 'WEBP', 300, 200);

    }

}
