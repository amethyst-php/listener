<?php

namespace Railken\LaraOre\Listener\Tests;

use Illuminate\Support\Facades\File;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Railken\LaraOre\ListenerServiceProvider::class,
        ];
    }
    
    protected function getPackageAliases($app)
    {
        return [
            'Twig' => \TwigBridge\Facade\Twig::class,
        ];
    }

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__.'/..', '.env');
        $dotenv->load();

        parent::setUp();

        File::cleanDirectory(database_path("migrations/"));

        $this->artisan('migrate:fresh');

        $this->artisan('vendor:publish', [
            '--provider' => 'Railken\LaraOre\WorkServiceProvider',
            '--force' => true
        ]);
        
        $this->artisan('migrate');

        $this->artisan('vendor:publish', [
            '--provider' => 'Railken\LaraOre\ListenerServiceProvider',
            '--force' => true
        ]);

        $this->artisan('vendor:publish', [
            '--provider' => 'Railken\LaraOre\Template\TemplateServiceProvider',
            '--force' => true
        ]);

        $this->artisan('migrate');
    }
}
