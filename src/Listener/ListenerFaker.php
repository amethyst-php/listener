<?php

namespace Railken\LaraOre\Listener;

use Railken\Bag;
use Faker\Factory;
use Railken\LaraOre\Work\WorkFaker;

class ListenerFaker
{
    /**
     * @return \Railken\Bag
     */
    public static function make()
    {
        $faker = Factory::create();
        
        $bag = new Bag();
        $bag->set('name', 'El. psy. congroo. '.microtime(true));
        $bag->set('condition', '{{ message is not empty ? 1 : 0 }}');
        $bag->set('work', WorkFaker::make()->toArray());
        $bag->set('event_class', 'Dummy');

        return $bag;
    }
}
