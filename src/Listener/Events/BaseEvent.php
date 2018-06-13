<?php

namespace Railken\LaraOre\Listener\Events;

use Illuminate\Queue\SerializesModels;

class BaseEvent
{
    use SerializesModels;

    public $data;
    public $entities;

    /**
     * @param array $data
     * @param array $entities
     */
    public function __construct(array $data, array $entities = [])
    {
        $this->data = $data;
        $this->entities = $entities;
    }
}
