<?php

namespace Railken\Amethyst\Repositories;

use Railken\Lem\Repository;

class ListenerRepository extends Repository
{
    /**
     * Find a listener given a event_class.
     *
     * @param string $event_class
     *
     * @return \Illuminate\Support\Collection
     */
    public function findByEventClass($event_class)
    {
        return $this->newQuery()->where('event_class', $event_class)->where('enabled', 1)->get();
    }
}
