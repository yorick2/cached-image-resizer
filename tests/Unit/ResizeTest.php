<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\Resize\Resize;
use Tests\ImageTestImageLocations;
use Tests\TestCase;
use Imagick;

class ResizeTest extends TestCase
{
    use ImageTestImageLocations;
    use ImageTestSetVariablesTrait;
    use ImageTestFilesTrait;

    private $imageClass;

    public function __construct(string $name = null, array $data = [], $dataName = '')
    {
        $this->imageClass = Resize::class;
        parent::__construct($name, $data, $dataName);
    }

    protected function canResize(string $filePath, string $format, int $width, int $height)
    {
        $newImageFilePath = __DIR__.'/../../testImages/cache/'.basename($filePath);
        $this->assertFileDoesNotExist($newImageFilePath);
        $this->imageClass::resize( $filePath, $newImageFilePath, $width);
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
