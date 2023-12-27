<?php

namespace Tests\Feature;

trait ImageTestSetVariablesTrait
{
    private string $imageFolder;
    private string $cacheFolderPath;


    /**
     * sets class variables.
     * Sets a class variable of name "$fileType.'LaravelImagePath'" where $fileType is the output from the regular expression
     * used on the current test name.
     * @param string $regularExpressionPattern
     * @return bool image type variables set
     */
    public function setClassVariables(string $regularExpressionPattern)
    {
        $this->laravelImageFolder = public_path('images');

        $this->cacheFolderPath = public_path('images/cache/');

        $testName = $this->getName();
        if(preg_match($regularExpressionPattern, $testName, $matches)){
            $this->imageFileType = lcfirst($matches[1]);
            $filepath = $this->{$this->imageFileType.'ModuleImagePath'};
            $variableName = $this->imageFileType.'ImageSubPath';
            $this->{$variableName} = basename($filepath);
            $this->{$this->imageFileType.'LaravelImagePath'} = $this->laravelImageFolder.'/'.$this->{$variableName};
            return true;
        }
        return false;
    }

}
