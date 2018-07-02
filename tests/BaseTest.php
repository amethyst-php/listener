<?php

namespace Railken\LaraOre\Listener\Tests;

use Illuminate\Support\Facades\File;
use Railken\Bag;
use Railken\LaraOre\Work\WorkFaker;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Railken\LaraOre\WorkServiceProvider::class,
            \Railken\LaraOre\ListenerServiceProvider::class,
        ];
    }

    /**
     * Retrieve correct bag of parameters.
     *
     * @return Bag
     */
    public function getParameters()
    {
        $bag = new bag();
        $bag->set('name', 'El. psy. congroo. '.microtime(true));
        $bag->set('condition', '{{ message is not empty ? 1 : 0 }}');
        $bag->set('work', WorkFaker::make()->toArray());
        $bag->set('event_class', 'Dummy');
        
        return $bag;
    }

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__.'/..', '.env');
        $dotenv->load();

        parent::setUp();

        $this->artisan('migrate:fresh');
    }
}
