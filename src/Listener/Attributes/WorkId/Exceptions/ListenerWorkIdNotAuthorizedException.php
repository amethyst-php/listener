<?php

namespace Railken\LaraOre\Listener\Attributes\WorkId\Exceptions;

use Railken\LaraOre\Listener\Exceptions\ListenerAttributeException;

class ListenerWorkIdNotAuthorizedException extends ListenerAttributeException
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
    protected $code = 'LISTENER_WORK_ID_NOT_AUTHTORIZED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = "You're not authorized to interact with %s, missing %s permission";
}
