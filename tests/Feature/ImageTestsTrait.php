<?php

namespace Tests\Feature;

use Imagick;

trait ImageTestsTrait
{

    public function ImageCreationSuccess(
        string $route,
        string $newImageFilePath,
        string $newFormat,
        int $width=0,
        int $height=0,
        bool $fileShouldAlreadyExist=false
    ){
        if($fileShouldAlreadyExist){
            $this->assertFileExists($newImageFilePath);
        }else{
            $this->assertFileDoesNotExist($newImageFilePath);
        }
        $response = $this->get($route);
        $response->assertStatus(200);
        $this->assertFileExists($newImageFilePath);
        $newImagick = new Imagick($newImageFilePath);
        if($width){
            $this->assertEquals($newImagick->getImageWidth(), $width);
        }
        if($height){
            $this->assertEquals($newImagick->getImageHeight(), $height);
        }
        $this->assertTrue(
            $newImagick->getImageFormat() === $newFormat,
            'cached image isn\'t a '.$newFormat
        );
        $newImagick->clear();
        $newImagick->destroy();
    }

}
