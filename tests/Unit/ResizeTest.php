<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\Resize\Resize;
use Tests\ImageTestImageLocations;
use Tests\TestCase;
use Tests\Helper\ImageTestsTrait as ImageTestsHelperTrait;
use Imagick;

class ResizeTest extends TestCase
{
    use ImageTestImageLocations;
    use ImageTestSetVariablesTrait;
    use ImageTestFilesTrait;
    use ImageTestsHelperTrait;

    private $imageClass;

    public function __construct(string $name = null, array $data = [], $dataName = '')
    {
        $this->imageClass = Resize::class;
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @param string $filePath
     * @param string $format
     * @param int $width
     * @param int $height
     * @return string new image file path
     * @throws \ImagickException
     */
    protected function canResize(string $filePath, string $format, int $width, int $height)
    {
        $newImageFilePath = __DIR__ . '/../../public/images/cache/' .basename($filePath);
        $this->assertFileDoesNotExist($newImageFilePath);
        $this->imageClass::resize( $filePath, $newImageFilePath, $width);
        $this->ImageCreationSuccess($newImageFilePath, $format, $width, $height);
        return $newImageFilePath;
    }

    public function test_canResizeJpgImage()
    {
        $this->canResize($this->jpgModuleImagePath, 'JPEG', 300, 200);
    }

    public function test_canResizePngImage()
    {
        $this->canResize($this->pngModuleImagePath, 'PNG', 300, 200);
    }

    public function test_canResizeWebpImage()
    {
        $this->canResize($this->webpModuleImagePath, 'WEBP', 300, 200);

    }

}
