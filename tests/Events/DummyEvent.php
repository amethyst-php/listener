<?php

namespace Railken\Amethyst\Tests\Events;

use Illuminate\Queue\SerializesModels;

class DummyEvent
{
    use SerializesModels;

    public $data;

    /**
     * Create a new event instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
