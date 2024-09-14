<?php

namespace Tests\Feature;

use Tests\Helper\ImageTestsTrait as ImageTestsHelperTrait;
use Imagick;

trait ImageTestsTrait
{
    use ImageTestsHelperTrait;

    public function ImageCreationGetRequestSuccess(
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
        $this->ImageCreationSuccess(
            $newImageFilePath,
            $newFormat,
            $width,
            $height
        );
    }

}
