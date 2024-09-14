<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\Resize\ImageResizer;
use Tests\ImageTestImageLocations;
use Tests\TestCase;
use Tests\Helper\ImageTestsTrait as ImageTestsHelperTrait;
use Imagick;

class ImageResizerTest extends TestCase
{
    use ImageTestImageLocations;
    use ImageTestSetVariablesTrait;
    use ImageTestFilesTrait;
    use ImageTestsHelperTrait;

    private $imageResizer;

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
     * @return string new file path
     * @throws \ImagickException
     */
    protected function canResize(string $filepath, string $format, int $width, int $height){
        $this->assertFileExists($filepath);
        $this->assertFileIsReadable($filepath);
        $newImageFilePath = realpath($this->cacheFolderPath).'/'.basename($filepath);
        $this->assertFileDoesNotExist($newImageFilePath);
        $this->imageResizer::resizeIfNeeded(
            realpath($filepath),
            $newImageFilePath,
            $width
        );
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
