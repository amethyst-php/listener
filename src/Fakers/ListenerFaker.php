<?php

namespace Railken\Amethyst\Fakers;

use Faker\Factory;
use Railken\Bag;
use Railken\Lem\Faker;
use Symfony\Component\Yaml\Yaml;

class ListenerFaker extends Faker
{
    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('name', 'El. psy. congroo. '.microtime(true));
        $bag->set('condition', '{{ message is not empty ? 1 : 0 }}');
        $bag->set('work', WorkFaker::make()->parametersWithEmail()->toArray());
        $bag->set('data', Yaml::dump([
            'dummy1' => 'dummy2',
        ]));
        $bag->set('event_class', 'Dummy');

        return $bag;
    }
}
