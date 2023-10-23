<?php

namespace Tests\Unit;

trait ImageTestSetVariablesTrait
{
    public function setClassVariables()
    {
        $this->laravelImageFolder = public_path('images');
        $this->cacheFolderPath = __DIR__.'/../../testImages/cache';
    }

}
