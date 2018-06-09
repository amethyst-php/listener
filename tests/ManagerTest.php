<?php

namespace Railken\LaraOre\Listener\Tests;

use Railken\LaraOre\Listener\ListenerManager;
use Railken\LaraOre\Listener\Tests\Events\DummyEvent;
use Railken\LaraOre\Support\Testing\ManagerTestableTrait;

class ManagerTest extends BaseTest
{
    use ManagerTestableTrait;

    /**
     * Retrieve basic url.
     *
     * @return \Railken\Laravel\Manager\Contracts\ManagerContract
     */
    public function getManager()
    {
        return new ListenerManager();
    }

    public function testSuccessCommon()
    {
        $this->commonTest($this->getManager(), $this->getParameters());
    }

    public function testWork()
    {
        $work = $this->getManager()->create($this->getParameters()->set('event_class', DummyEvent::class))->getResource();

        event(new DummyEvent([
            'user' => [
                'email' => 'test@test.net',
                'name'  => '024',
            ],
            'message' => 'El. psy. congroo.',
        ]));
    }
}
