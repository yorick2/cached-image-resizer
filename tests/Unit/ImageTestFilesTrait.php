<?php

namespace Tests\Unit;

trait ImageTestFilesTrait
{
    private string $laravelImageFolder;
    private string $cacheFolderPath;


    public function setUp(): void
    {
        parent::setUp();
        $this->setClassVariables();
        $this->setUpImages();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->emptyFolderOfFiles($this->cacheFolderPath);
    }

    protected function setUpImages()
    {
        $this->emptyFolderOfFiles($this->cacheFolderPath);
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
}
