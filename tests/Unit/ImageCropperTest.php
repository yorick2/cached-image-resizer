<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\Crop\ImageCropper;
use Tests\ImageTestImageLocations;
use Tests\TestCase;
use Tests\Helper\ImageTestsTrait as ImageTestsHelperTrait;

class ImageCropperTest extends TestCase
{
    use ImageTestImageLocations;
    use ImageTestSetVariablesTrait;
    use ImageTestFilesTrait;
    use ImageTestsHelperTrait;
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
     * @return string new file path
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
        $this->ImageCreationSuccess($newImageFilePath, $format, $width, $height);
        return $newImageFilePath;
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
