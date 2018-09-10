<?php

namespace Railken\LaraOre\Tests\Listener;

use Railken\LaraOre\Listener\ListenerFaker;
use Railken\LaraOre\Listener\ListenerManager;
use Railken\LaraOre\Tests\Listener\Events\DummyEvent;
use Railken\LaraOre\Support\Testing\ManagerTestableTrait;
use Railken\LaraOre\EmailSender\EmailSenderFaker;
use Railken\LaraOre\EmailSender\EmailSenderManager;
use Railken\LaraOre\ListenerServiceProvider;

class ManagerTest extends BaseTest
{
    use ManagerTestableTrait;

    /**
     * @return \Railken\Laravel\Manager\Contracts\ManagerContract
     */
    public function getManager()
    {
        return new ListenerManager();
    }

    public function testSuccessCommon()
    {
        $this->commonTest($this->getManager(), ListenerFaker::make()->parameters());
    }

    public function testWork()
    {

        $esm = new EmailSenderManager();
        $es = $esm->create(EmailSenderFaker::make()->parameters()->set('body', '{{ user.name }}'))->getResource();
        
        $listener = ListenerFaker::make()->parameters()->set('data', ['user_name' => '{{ user.name }}'])->set('work.payload.data.id', $es->id)->set('event_class', DummyEvent::class);

        $this->getManager()->create($listener)->getResource();

        // reload
        (new ListenerServiceProvider($this->app))->boot();

        event(new DummyEvent([
            'user' => [
                'email' => 'test@test.net',
                'name'  => '024',
            ],
            'message' => 'El. psy. congroo.',
        ]));
    }
}
