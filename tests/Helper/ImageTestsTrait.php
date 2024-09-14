<?php

namespace Tests\Helper;

use Imagick;

trait ImageTestsTrait
{

    /**
     * @param string $newImageFilePath
     * @param string $format
     * @param int $width
     * @param int $height
     * @throws \ImagickException
     */
    public function ImageCreationSuccess(
        string $newImageFilePath,
        string $format='',
        int $width=0,
        int $height=0
    ){
        $this->assertFileExists($newImageFilePath);
        $imagick = new Imagick($newImageFilePath);
        if($width){
            $this->assertEquals($imagick->getImageWidth(), $width);
        }
        if($height){
            $this->assertEquals($imagick->getImageHeight(), $height);
        }
        if($format){
            $this->assertTrue(
                $imagick->getImageFormat() === $format,
                'cached image isn\'t a '.$format
            );
        }
        $imagick->clear();
        $imagick->destroy();
    }
}
