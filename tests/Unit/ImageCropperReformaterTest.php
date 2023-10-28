<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\Crop\ImageCropper;
use Tests\ImageTestImageLocations;
use Tests\TestCase;
use Imagick;

class ImageCropperReformaterTest extends TestCase
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
    protected function canCropAndReformat(string $filepath, string $format, int $width, int $height, string $newFileExtension){
        $this->assertFileExists($filepath);
        $this->assertFileIsReadable($filepath);
        $newImageFilePath = realpath(__DIR__.'/../../testImages/cache').'/'.
            str_replace('.', '-', basename($filepath)).'.'.$newFileExtension;
        $this->assertFileDoesNotExist($newImageFilePath);
        $this->imageCropper::resizeAndCropIfNeeded(
            realpath($filepath),
            $newImageFilePath,
            $format,
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

    public function test_canCropWebpIntoJPGImage()
    {
        $this->canCropAndReformat($this->webpModuleImagePath, 'JPEG', 300, 200, 'jpg');
    }

    public function test_canCropWebpImageIntoJPGWithOnlyWidthGiven()
    {
        $this->canCropAndReformat($this->webpModuleImagePath, 'JPEG', 300, 0, 'jpg');
    }

    public function test_canCropWebpImageIntoJPGWithOnlyHeightGiven()
    {
        $this->canCropAndReformat($this->webpModuleImagePath, 'JPEG', 0, 200, 'jpg');
    }

    public function test_canCropWebpIntoPngImage()
    {
        $this->canCropAndReformat($this->webpModuleImagePath, 'PNG', 300, 200, 'png');
    }

    public function test_canCropWebpIntoPngImageWithOnlyWidthGiven()
    {
        $this->canCropAndReformat($this->webpModuleImagePath, 'PNG', 300, 0, 'png');
    }

    public function test_canCropWebpIntoPngImageWithOnlyHeightGiven()
    {
        $this->canCropAndReformat($this->webpModuleImagePath, 'PNG', 0, 200, 'png');
    }

    public function test_canCropSVGIntoPngImage()
    {
        $this->canCropAndReformat($this->svgModuleImagePath, 'PNG', 300, 200, 'png');
    }

    public function test_canCropSvgIntoPngImageWithOnlyWidthGiven()
    {
        $this->canCropAndReformat($this->svgModuleImagePath, 'PNG', 300, 0, 'png');
    }

    public function test_canCropSvgIntoPngImageWithOnlyHeightGiven()
    {
        $this->canCropAndReformat($this->svgModuleImagePath, 'PNG', 0, 200, 'png');
    }

    public function test_canCropSVGIntoJpgImage()
    {
        $this->canCropAndReformat($this->svgModuleImagePath, 'JPEG', 300, 200, 'jpg');
    }

    public function test_canCropSvgIntoJpgImageWithOnlyWidthGiven()
    {
        $this->canCropAndReformat($this->svgModuleImagePath, 'JPEG', 300, 0, 'jpg');
    }

    public function test_canCropSvgIntoJpgImageWithOnlyHeightGiven()
    {
        $this->canCropAndReformat($this->svgModuleImagePath, 'JPEG', 0, 200, 'jpg');
    }

}
