<?php

namespace Railken\Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class ListenerAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'listener.create',
        Tokens::PERMISSION_UPDATE => 'listener.update',
        Tokens::PERMISSION_SHOW   => 'listener.show',
        Tokens::PERMISSION_REMOVE => 'listener.remove',
    ];
}
