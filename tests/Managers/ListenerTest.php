<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\EmailSenderFaker;
use Amethyst\Fakers\ListenerFaker;
use Amethyst\Managers\EmailSenderManager;
use Amethyst\Managers\ListenerManager;
use Amethyst\Providers\ListenerServiceProvider;
use Amethyst\Tests\BaseTest;
use Amethyst\Tests\Events\DummyEvent;
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
