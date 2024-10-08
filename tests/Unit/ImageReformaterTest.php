<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\Reformat\ImageReformater;
use Tests\ImageTestImageLocations;
use Tests\TestCase;
use Tests\Helper\ImageTestsTrait as ImageTestsHelperTrait;
use Imagick;

class ImageReformaterTest extends TestCase
{
    use ImageTestImageLocations;
    use ImageTestSetVariablesTrait;
    use ImageTestFilesTrait;
    use ImageTestsHelperTrait;

    private $imageReformater;

    public function __construct(string $name = null, array $data = [], $dataName = '')
    {
        $this->imageReformater = ImageReformater::class;
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @param string $originalFile
     * @param string $newFormat
     * @param string $newFileExtension
     * @param int $width
     * @param int $height
     * @throws \ImagickException
     */
    protected function canConvertImageFileFormats(
        string $originalFile,
        string $newFormat,
        string $newFileExtension,
        int $width=0,
        int $height=0
    ){
        $this->assertFileExists($originalFile);
        $this->assertFileIsReadable($originalFile);
        $newImageFilePath = realpath(__DIR__ . '/../../public/images/cache').'/'.
            str_replace('.', '-', basename($originalFile)).'.'.$newFileExtension;
        $this->assertFileDoesNotExist($newImageFilePath);
        $this->imageReformater::resizeAndReformatIfNeeded(
            realpath($originalFile),
            $newImageFilePath,
            $newFormat,
            $width,
            $height
        );
        $oldImagick = new Imagick($originalFile);
        if($width==0){
            $width = $oldImagick->getImageWidth();
        }
        if($height==0){
            $height = $oldImagick->getImageHeight();
        }
        $this->ImageCreationSuccess($newImageFilePath, $newFormat, $width, $height);
        return $newImageFilePath;
    }

    public function test_canConvertImageFileFormatsFromWebpToJpg()
    {
        $this->canConvertImageFileFormats(
            $this->jpgModuleImagePath,
            'JPEG',
            'jpg');
    }

    public function test_canConvertImageFileFormatsFromWebpToPng()
    {
        $this->canConvertImageFileFormats(
            $this->webpModuleImagePath,
            'PNG',
            'png');
    }


    public function test_canConvertImageFileFormatsFromSvgToJpg()
    {
        $this->canConvertImageFileFormats(
            $this->svgModuleImagePath,
            'JPEG',
            'jpg',
            200,
            133
        );
    }

    public function test_canConvertImageFileFormatsFromSvgToWebp()
    {
        $this->canConvertImageFileFormats(
            $this->svgModuleImagePath,
            'WEBP',
            'webp',
            200,
            133
        );
    }

    public function test_canConvertImageFileFormatsFromSvgToPng()
    {
        $this->canConvertImageFileFormats(
            $this->svgModuleImagePath,
            'PNG',
            'png',
            200,
            133
        );
    }

    public function test_canConvertImageFileFormatsFromSvgToPngWithTransparency()
    {
        $this->canConvertImageFileFormats(
            $this->svgWithTransparencyModuleImagePath,
            'PNG',
            'png',
            200,
            133
        );
    }

}
