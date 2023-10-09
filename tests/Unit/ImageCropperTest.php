<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\ImageCropper;
use Tests\TestCase;
use Imagick;

class ImageCropperTest extends TestCase
{
    const IMAGE_LOCATION_JPG = __DIR__.'/../../testImages/laptop-400X266.jpg';
    const IMAGE_LOCATION_PNG = __DIR__.'/../../testImages/laptop-400X266.png';
    const IMAGE_LOCATION_WEBP = __DIR__.'/../../testImages/laptop-400X266.webp';
    private $cacheFolderPath = __DIR__.'/../../testImages/cache';
    private $imageCropper;

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
        $this->imageCropper = ImageCropper::class;
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @param string $filepath
     * @param string $format
     * @param int $width
     * @param int $height
     * @throws \ImagickException
     */
    protected function canCrop(string $filepath, string $format, int $width, int $height){
        $newImageFilePath = realpath($this->cacheFolderPath).'/'.basename($filepath);
        $this->imageCropper::cropIfNeeded(
            realpath($filepath),
            $newImageFilePath,
            $width,
            $height
        );
        $imagick = new Imagick($newImageFilePath);
        $this->assertEquals($imagick->getImageWidth(), $width);
        $this->assertEquals($imagick->getImageHeight(), $height);
        $this->assertTrue($imagick->getImageFormat() === $format, 'cached image isn\'t a '.$format);
        $imagick->clear();
        $imagick->destroy();
    }

    public function test_canCropJpgImage()
    {
        $this->canCrop(self::IMAGE_LOCATION_JPG, 'JPEG', 300, 200);
    }

    public function test_canCropPngImage()
    {
        $this->canCrop(self::IMAGE_LOCATION_PNG, 'PNG', 300, 200);
    }

    public function test_canCropWebpImage()
    {
        $this->canCrop(self::IMAGE_LOCATION_WEBP, 'WEBP', 300, 200);
    }

    public function test_canCropJpgImageWithOnlyWidthGiven()
    {
        $this->canCrop(self::IMAGE_LOCATION_JPG, 'JPEG', 300);
    }

    public function test_canCropPngImageWithOnlyWidthGiven()
    {
        $this->canCrop(self::IMAGE_LOCATION_PNG, 'PNG', 300);
    }

    public function test_canCropWebpImageWithOnlyWidthGiven()
    {
        $this->canCrop(self::IMAGE_LOCATION_WEBP, 'WEBP', 300);
    }

    public function test_canCropJpgImageWithOnlyHeightGiven()
    {
        $this->canCrop(self::IMAGE_LOCATION_JPG, 'JPEG', 0, 200);
    }

    public function test_canCropPngImageWithOnlyHeightGiven()
    {
        $this->canCrop(self::IMAGE_LOCATION_PNG, 'PNG', 0, 200);
    }

    public function test_canCropWebpImageWithOnlyHeightGiven()
    {
        $this->canCrop(self::IMAGE_LOCATION_WEBP, 'WEBP', 0, 200);
    }

    public function test_canCropImageToAspectRatio()
    {
        $this->assertTrue(false);
    }

}
