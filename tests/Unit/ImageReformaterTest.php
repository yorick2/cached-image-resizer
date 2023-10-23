<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\Reformat\ImageReformater;
use Tests\ImageTestImageLocations;
use Tests\TestCase;
use Imagick;

class ImageReformaterTest extends TestCase
{
    use ImageTestImageLocations;
    use ImageTestSetVariablesTrait;
    use ImageTestFilesTrait;

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
        $newImageFilePath = realpath(__DIR__.'/../../testImages/cache').'/'.
            str_replace('.', '-', basename($originalFile)).$newFileExtension;
        $this->assertFileDoesNotExist($newImageFilePath);
        $this->imageReformater::reformatIfNeeded(
            realpath($originalFile),
            $newImageFilePath,
            $newFormat,
            $width,
            $height
        );
        $oldImagick = new Imagick($originalFile);
        $newImagick = new Imagick($newImageFilePath);
        if($width==0){
            $width = $oldImagick->getImageWidth();
        }
        if($height==0){
            $height = $oldImagick->getImageHeight();
        }
        $this->assertEquals($newImagick->getImageWidth(), $width);
        $this->assertEquals($newImagick->getImageHeight(), $height);
        $this->assertTrue($newImagick->getImageFormat() === $newFormat, 'cached image isn\'t a '.$newFormat);
        $newImagick->clear();
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
