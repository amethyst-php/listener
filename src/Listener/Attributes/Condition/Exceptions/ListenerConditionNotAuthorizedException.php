<?php

namespace Railken\LaraOre\Listener\Attributes\Condition\Exceptions;

use Railken\LaraOre\Listener\Exceptions\ListenerAttributeException;

class ListenerConditionNotAuthorizedException extends ListenerAttributeException
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
    protected $code = 'LISTENER_CONDITION_NOT_AUTHTORIZED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = "You're not authorized to interact with %s, missing %s permission";
}
