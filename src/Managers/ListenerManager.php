<?php

namespace Amethyst\Managers;

use Amethyst\Core\ConfigurableManager;
use Railken\Lem\Manager;

/**
 * @method \Amethyst\Models\Listener                 newEntity()
 * @method \Amethyst\Schemas\ListenerSchema          getSchema()
 * @method \Amethyst\Repositories\ListenerRepository getRepository()
 * @method \Amethyst\Serializers\ListenerSerializer  getSerializer()
 * @method \Amethyst\Validators\ListenerValidator    getValidator()
 * @method \Amethyst\Authorizers\ListenerAuthorizer  getAuthorizer()
 */
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
        /** @var \Amethyst\Repositories\ListenerRepository */
        $repository = $this->getRepository();

        return $repository->newQuery()->get()->map(function ($v) {
            return $v->event_class;
        })->toArray();
    }
}
