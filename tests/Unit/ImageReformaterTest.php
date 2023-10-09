<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\Helper\ImageCacheFolderPath;
use paulmillband\cachedImageResizer\App\Models\ImageReformater;
use paulmillband\cachedImageResizer\App\Models\ImageResizer;
use Tests\TestCase;
use Imagick;

class ImageReformaterTest extends TestCase
{
    const IMAGE_LOCATION_JPG = __DIR__.'/../../testImages/laptop-400X266.jpg';
    const IMAGE_LOCATION_PNG = __DIR__.'/../../testImages/laptop-400X266.png';
    const IMAGE_LOCATION_WEBP = __DIR__.'/../../testImages/laptop-400X266.webp';
    const IMAGE_LOCATION_SVG = __DIR__.'/../../testImages/laptop-400X266.svg';
    const IMAGE_LOCATION_SVG_TRANSPARENCY = __DIR__.'/../../testImages/laptop-transparency-400X266.svg';
    private $cacheFolderPath = __DIR__.'/../../testImages/cache';
    private $imageReformater;

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
            self::IMAGE_LOCATION_WEBP,
            'JPEG',
            'jpg');
    }

    public function test_canConvertImageFileFormatsFromWebpToPng()
    {
        $this->canConvertImageFileFormats(
            self::IMAGE_LOCATION_WEBP,
            'PNG',
            'png');
    }


    public function test_canConvertImageFileFormatsFromSvgToJpg()
    {
        $this->canConvertImageFileFormats(
            self::IMAGE_LOCATION_SVG,
            'JPEG',
            'jpg',
            200,
            133
        );
    }

    public function test_canConvertImageFileFormatsFromSvgToWebp()
    {
        $this->canConvertImageFileFormats(
            self::IMAGE_LOCATION_SVG,
            'WEBP',
            'webp',
            200,
            133
        );
    }

    public function test_canConvertImageFileFormatsFromSvgToPng()
    {
        $this->canConvertImageFileFormats(
            self::IMAGE_LOCATION_SVG,
            'PNG',
            'png',
            200,
            133
        );
    }

    public function test_canConvertImageFileFormatsFromSvgToPngWithTransparency()
    {
        $this->canConvertImageFileFormats(
            self::IMAGE_LOCATION_SVG_TRANSPARENCY,
            'PNG',
            'png',
            200,
            133
        );
    }

}
