<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\Helper\ImageCacheFolderPath;
use paulmillband\cachedImageResizer\App\Models\ImageReformater;
use paulmillband\cachedImageResizer\App\Models\ImageResizer;
use Tests\TestCase;
use Imagick;

class ImageResizerTest extends TestCase
{
    const IMAGE_LOCATION_JPG = __DIR__.'/../../testImages/laptop-400X266.jpg';
    const IMAGE_LOCATION_PNG = __DIR__.'/../../testImages/laptop-400X266.png';
    const IMAGE_LOCATION_WEBP = __DIR__.'/../../testImages/laptop-400X266.webp';
    private $cacheFolderPath = __DIR__.'/../../testImages/cache';
    private $imageResizer;

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

    public function __construct(string $name = null, array $data = [], $dataName = '')
    {
        $this->imageResizer = ImageResizer::class;
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @param string $filepath
     * @param string $format
     * @param int $width
     * @param int $height
     * @throws \ImagickException
     */
    protected function canResize(string $filepath, string $format, int $width, int $height){
        $newImageFilePath = realpath($this->cacheFolderPath).'/'.basename($filepath);
        $this->imageResizer::resizeIfNeeded(
            realpath($filepath),
            $newImageFilePath,
            $width
        );
        $imagick = new Imagick($newImageFilePath);
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
