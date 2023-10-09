<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\URL;
use paulmillband\cachedImageResizer\App\Models\ImageResizer;
use Tests\TestCase;
use Imagick;
use function Symfony\Component\String\lower;

class ImageCropperTest extends TestCase
{
    const IMAGE_LOCATION_JPG = __DIR__.'/../../testImages/laptop-400X266.jpg';
    const IMAGE_LOCATION_PNG = __DIR__.'/../../testImages/laptop-400X266.png';
    const IMAGE_LOCATION_WEBP = __DIR__.'/../../testImages/laptop-400X266.webp';
    private $imageFolder;
    private $publicPath;
    private string $cacheFolderPath;
    private string $jpgImageSubPath;
    private string $jpgImagePath;
    private string $pngImageSubPath;
    private string $pngImagePath;
    private string $webpImageSubPath;
    private string $webpImagePath;

    public function __construct(string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->imageResizer = ImageResizer::class;
        $this->imageFolder = public_path('images');

        $this->cacheFolderPath = public_path('images/cache/');
        $files = glob($this->cacheFolderPath."/*/*/*/*");
        foreach($files as $file){
            if(is_file($file)) {
                unlink($file);
            }
        }

        $testName = $this->getName();
        if(preg_match("/canResize([A-Z][a-z]*)ImageBy/", $testName, $matches)){
            $this->copyFileToPublicFolder(strtolower($matches[1]));
        }
    }

    /**
     * @param string $fileType
     */
    protected function copyFileToPublicFolder(string $fileType){
        $filepath = constant('self::IMAGE_LOCATION_'.strtoupper($fileType));
        $x =$fileType.'ImageSubPath';
        $this->{$fileType.'ImageSubPath'} = '/test/'.basename($filepath);
        $this->{$fileType.'ImagePath'} = public_path('images'.$this->{$fileType.'ImageSubPath'});
        $imgFolderPath = dirname($this->{$fileType.'ImagePath'});
        if(!is_dir($imgFolderPath)){
            mkdir($imgFolderPath, 0775, true);
        }
        $copySuccess = copy(
            $filepath,
            $this->{$fileType.'ImagePath'}
        );
        $this->assertTrue($copySuccess, 'Test image could not be copied into place to prepare for test');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $files = glob($this->cacheFolderPath."/*/*/*/*");
        foreach($files as $file){
            if(is_file($file)) {
                unlink($file);
            }
        }
        $files = glob($this->imageFolder.'/*');
        foreach($files as $file){
            if(is_file($file)) {
                unlink($file);
            }
        }
    }

    public function test_canCrop()
    {
      $this->assertTrue(false);
    }

}
