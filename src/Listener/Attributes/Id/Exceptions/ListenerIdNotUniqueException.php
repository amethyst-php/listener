<?php

namespace Railken\LaraOre\Listener\Attributes\Id\Exceptions;

use Railken\LaraOre\Listener\Exceptions\ListenerAttributeException;

class ListenerIdNotUniqueException extends ListenerAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'id';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'LISTENER_ID_NOT_UNIQUE';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not unique';
}
