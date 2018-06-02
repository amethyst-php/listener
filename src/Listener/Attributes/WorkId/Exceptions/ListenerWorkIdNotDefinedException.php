<?php

namespace Railken\LaraOre\Listener\Attributes\WorkId\Exceptions;

use Railken\LaraOre\Listener\Exceptions\ListenerAttributeException;

class ListenerWorkIdNotDefinedException extends ListenerAttributeException
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
    protected $code = 'LISTENER_WORK_ID_NOT_DEFINED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is required';
}
