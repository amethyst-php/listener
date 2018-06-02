<?php

namespace Railken\LaraOre\Listener\Attributes\WorkId\Exceptions;

use Railken\LaraOre\Listener\Exceptions\ListenerAttributeException;

class ListenerWorkIdNotUniqueException extends ListenerAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'work_id';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'LISTENER_WORK_ID_NOT_UNIQUE';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not unique';
}
