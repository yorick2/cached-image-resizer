<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\Crop\ImageCropper;
use Tests\ImageTestImageLocations;
use Tests\TestCase;
use Imagick;

class ImageCropperTest extends TestCase
{
    use ImageTestImageLocations;
    use ImageTestSetVariablesTrait;
    use ImageTestFilesTrait;
    private $imageCropper;

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
    protected function canCrop(string $filepath, string $format, int $width, int $height=0){
        $this->assertFileExists($filepath);
        $this->assertFileIsReadable($filepath);
        $newImageFilePath = realpath($this->cacheFolderPath).'/'.basename($filepath);
        $this->assertFileDoesNotExist($newImageFilePath);
        $this->imageCropper::resizeAndCropIfNeeded(
            realpath($filepath),
            $newImageFilePath,
            '',
            -1,
            -1,
            $width,
            $height
        );
        $imagick = new Imagick($newImageFilePath);
        if($width){
            $this->assertEquals($imagick->getImageWidth(), $width);
        }
        if($height){
            $this->assertEquals($imagick->getImageHeight(), $height);
        }
        $this->assertTrue($imagick->getImageFormat() === $format, 'cached image isn\'t a '.$format);
        $imagick->clear();
        $imagick->destroy();
    }

    public function test_canCropJpgImage()
    {
        $this->canCrop($this->jpgModuleImagePath, 'JPEG', 300, 200);
    }

    public function test_canCropPngImage()
    {
        $this->canCrop($this->pngModuleImagePath, 'PNG', 300, 200);
    }

    public function test_canCropWebpImage()
    {
        $this->canCrop($this->webpModuleImagePath, 'WEBP', 300, 200);
    }

    public function test_canCropJpgImageWithOnlyWidthGiven()
    {
        $this->canCrop($this->jpgModuleImagePath, 'JPEG', 300);
    }

    public function test_canCropPngImageWithOnlyWidthGiven()
    {
        $this->canCrop($this->pngModuleImagePath, 'PNG', 300);
    }

    public function test_canCropWebpImageWithOnlyWidthGiven()
    {
        $this->canCrop($this->webpModuleImagePath, 'WEBP', 300);
    }

    public function test_canCropJpgImageWithOnlyHeightGiven()
    {
        $this->canCrop($this->jpgModuleImagePath, 'JPEG', 0, 200);
    }

    public function test_canCropPngImageWithOnlyHeightGiven()
    {
        $this->canCrop($this->pngModuleImagePath, 'PNG', 0, 200);
    }

    public function test_canCropWebpImageWithOnlyHeightGiven()
    {
        $this->canCrop($this->webpModuleImagePath, 'WEBP', 0, 200);
    }

}
