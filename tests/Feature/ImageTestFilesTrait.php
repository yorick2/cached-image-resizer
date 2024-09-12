<?php

namespace Tests\Feature;

trait ImageTestFilesTrait
{
    private string $laravelImageFolder;
    private string $cacheFolderPath;

    /**
     * adds test images to the images folder and clears the images/cache folder
     * @param string $sourceFilepath
     * @param string $destFilepath
     */
    public function setUpImages(string $sourceFilepath, string $destFilepath): void
    {
        $this->emptyFolderOfFiles($this->cacheFolderPath);
        $this->copyFileToPublicFolder($sourceFilepath, $destFilepath);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->emptyFolderOfFiles($this->cacheFolderPath);
        $this->emptyFolderOfFiles($this->laravelImageFolder, 1);
    }

    /**
     * @param string $folderPath
     * @param int $depth
     */
    protected function emptyFolderOfFiles(string $folderPath, $depth=10){
        for ($i = 1; $i < $depth; $i++) {
            $path = $folderPath.str_repeat('/*', $i);
            $files = glob($path);
            foreach($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
    }

    /**
     * @param string $sourceFilepath
     * @param string $destFilepath
     */
    protected function copyFileToPublicFolder(string $sourceFilepath, string $destFilepath){
        $this->assertFileExists($sourceFilepath, 'sourceFile dos not exist');
        $imgFolderPath = dirname($destFilepath);
        if(!is_dir($imgFolderPath)){
            mkdir($imgFolderPath, 0775, true);
        }
        $copySuccess = copy(
            $sourceFilepath,
            $destFilepath
        );
        $this->assertTrue($copySuccess, 'Test image could not be copied into place to prepare for test');
    }

}
