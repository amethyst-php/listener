<?php

namespace Railken\LaraOre\Listener\Tests\Events;

use Illuminate\Queue\SerializesModels;

class DummyEvent
{
    use SerializesModels;

    public $data;

    /**
     * @param array $data
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
