<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\Image;
use Tests\ImageTestImageLocations;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use ImageTestImageLocations;
    use ImageTestSetVariablesTrait;
    use ImageTestFilesTrait;

    private $imageClass;

    public function __construct(string $name = null, array $data = [], $dataName = '')
    {
        $this->imageClass = Image::class;
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @return void
     */
    public function test_canCreateOriginalImageClass()
    {
        $image = new $this->imageClass($this->jpgModuleImagePath);
        $this->assertEquals($image->filePath,$this->jpgModuleImagePath);
    }

    public function test_canGetImageType(){
        $image = new $this->imageClass($this->jpgModuleImagePath);
        $this->assertEquals($image->getImageType(),'image/jpeg');
    }

    public function testCanGetImageUrl(){
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__.'/../../');
        $image = new $this->imageClass($this->jpgModuleImagePath);
        $this->assertEquals($image->url,
            'https://'.$_SERVER['HTTP_HOST'].'/images/laptop-400X266.jpg');
    }

}
