<?php

namespace Railken\LaraOre\Listener\Tests;

use Railken\Bag;
use Illuminate\Support\Facades\File;
use Railken\LaraOre\Work\WorkManager;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Railken\LaraOre\WorkServiceProvider::class,
            \Railken\LaraOre\ListenerServiceProvider::class,
        ];
    }


    public function newWork()
    {
        $bag = new Bag();
        $bag->set('name', "El. psy. congroo. " . microtime(true));
        $bag->set('worker', 'Railken\LaraOre\Workers\EmailWorker');
        $bag->set('extra', [
            'to' => "{{ user.email }}",
            'subject' => "Welcome to the laboratory lab {{ user.name }}",
            'body' => "{{ message }}"
        ]);

        $wm = new WorkManager();
        return $wm->create($bag)->getResource();
    }

    /**
     * Retrieve correct bag of parameters.
     *
     * @return Bag
     */
    public function getParameters()
    {
        $bag = new bag();
        $bag->set('name', "El. psy. congroo. " . microtime(true));
        $bag->set('condition', "{{ message is not empty ? 1 : 0 }}");
        $bag->set('work_id', $this->newWork()->id);
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

        File::cleanDirectory(database_path("migrations/"));

        $this->artisan('migrate:fresh');
        $this->artisan('lara-ore:user:install');

        $this->artisan('vendor:publish', [
            '--provider' => 'Railken\LaraOre\ListenerServiceProvider',
            '--force' => true
        ]);

        $this->artisan('migrate');
    }
}
