<?php

namespace Railken\Amethyst\Managers;

use Railken\Amethyst\Common\ConfigurableManager;
use Railken\Lem\Manager;

class ListenerManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.listener.data.listener';

    /**
     * Retrieve all events_class available.
     *
     * @return array
     */
    public function getAvailableEventClasses()
    {
        /** @var \Railken\Amethyst\Repositories\ListenerRepository */
        $repository = $this->getRepository();

        return $repository->newQuery()->get()->map(function ($v) {
            return $v->event_class;
        })->toArray();
    }
}
