<?php

namespace Tests\Unit;

use paulmillband\cachedImageResizer\App\Models\Image;
use PhpParser\Node\Scalar\MagicConst\Dir;
use Tests\TestCase;

class ImageTest extends TestCase
{
    const IMAGE_LOCATION_JPG = __DIR__.'/../../testImages/laptop-400X266.jpg';
    const IMAGE_LOCATION_PNG = __DIR__.'/../../testImages/laptop-400X266.png';
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
        $image = new $this->imageClass(self::IMAGE_LOCATION_JPG);
        $this->assertEquals($image->filePath,self::IMAGE_LOCATION_JPG);
    }

    public function test_canGetImageType(){
        $image = new $this->imageClass(self::IMAGE_LOCATION_JPG);
        $this->assertEquals($image->getImageType(),'image/jpeg');
    }

    public function testCanGetImageUrl(){
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__.'/../../');
        $image = new $this->imageClass(self::IMAGE_LOCATION_JPG);
        $this->assertEquals($image->url,
            'https://'.$_SERVER['HTTP_HOST'].'/testImages/laptop-400X266.jpg');
    }

}
