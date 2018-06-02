<?php

namespace Railken\LaraOre\Listener\Tests;

use Railken\Bag;
use Railken\LaraOre\Listener\ListenerManager;
use Railken\LaraOre\Work\WorkManager;
use Railken\LaraOre\Listener\Tests\Events\DummyEvent;

class ListenerTest extends BaseTest
{
    use Traits\CommonTrait;


    /**
     * Retrieve basic url.
     *
     * @return \Railken\Laravel\Manager\Contracts\ManagerContract
     */
    public function getManager()
    {
        return new ListenerManager();
    }

    public function newWork()
    {
        $bag = new bag();
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
        $bag->set('work', $this->newWork());
        $bag->set('event_class', 'Dummy');
        return $bag;
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
                'name' => '024',
            ],
            'message' => 'El. psy. congroo.'
        ]));
    }
}
