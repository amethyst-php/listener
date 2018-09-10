<?php

namespace Railken\LaraOre\Tests\Listener\Events;

use Illuminate\Queue\SerializesModels;

class DummyEvent
{
    use SerializesModels;

    public $data;

    /**
     * Create a new event instance.
     *
     * @param \App\Order $order
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
