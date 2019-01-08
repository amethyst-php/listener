<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\EmailSenderFaker;
use Railken\Amethyst\Fakers\ListenerFaker;
use Railken\Amethyst\Managers\EmailSenderManager;
use Railken\Amethyst\Managers\ListenerManager;
use Railken\Amethyst\Providers\ListenerServiceProvider;
use Railken\Amethyst\Tests\BaseTest;
use Railken\Amethyst\Tests\Events\DummyEvent;
use Railken\Lem\Support\Testing\TestableBaseTrait;
use Symfony\Component\Yaml\Yaml;

class ListenerTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = ListenerManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = ListenerFaker::class;

    public function testWork()
    {
        $esm = new EmailSenderManager();
        $es = $esm->create(EmailSenderFaker::make()->parameters()->set('body', '{{ user.name }}'))->getResource();

        $listener = ListenerFaker::make()->parameters()
            ->set('data', Yaml::dump(['user_name' => '{{ user.name }}']))
            ->set('work.payload.data.id', $es->id)
            ->set('event_class', DummyEvent::class)
        ;

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
