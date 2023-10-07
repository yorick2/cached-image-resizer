<?php

namespace Tests;

use paulmillband\cachedImageResizer\ImageResizerPackageServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Automatically enables package discoveries.
     *
     * @var bool
     */
    protected $enablesPackageDiscoveries = true;

    public function setUp(): void
    {
        parent::setUp();
        // additional setup
//        $_SERVER['HTTPS'] = 'on';
//        $_SERVER['HTTP_HOST'] = 'dev.laravel';
//        $_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__.'/../../');
    }

    protected function getPackageProviders($app)
    {
        return [
            ImageResizerPackageServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
