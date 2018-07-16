<?php

namespace Railken\LaraOre\Events;

use Illuminate\Queue\SerializesModels;

class WorkBaseEvent
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

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getEntities()
    {
        return $this->data;
    }
}
