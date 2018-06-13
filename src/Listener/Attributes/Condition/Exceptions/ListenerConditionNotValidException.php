<?php

namespace Railken\LaraOre\Listener\Attributes\Condition\Exceptions;

use Railken\LaraOre\Listener\Exceptions\ListenerAttributeException;

class ListenerConditionNotValidException extends ListenerAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'condition';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'LISTENER_CONDITION_NOT_VALID';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not valid';
}
