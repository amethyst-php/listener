<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    |
    | Here you can change the table name and the class components.
    |
    */
    'data' => [
        'listener' => [
            'table'      => 'amethyst_listeners',
            'comment'    => 'Listener',
            'model'      => Railken\Amethyst\Models\Listener::class,
            'schema'     => Railken\Amethyst\Schemas\ListenerSchema::class,
            'repository' => Railken\Amethyst\Repositories\ListenerRepository::class,
            'serializer' => Railken\Amethyst\Serializers\ListenerSerializer::class,
            'validator'  => Railken\Amethyst\Validators\ListenerValidator::class,
            'authorizer' => Railken\Amethyst\Authorizers\ListenerAuthorizer::class,
            'faker'      => Railken\Amethyst\Fakers\ListenerFaker::class,
            'manager'    => Railken\Amethyst\Managers\ListenerManager::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Http configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the routes
    |
    */
    'http' => [
        'admin' => [
            'listener' => [
                'enabled'    => true,
                'controller' => Railken\Amethyst\Http\Controllers\Admin\ListenersController::class,
                'router'     => [
                    'as'     => 'listener.',
                    'prefix' => '/listeners',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Events Listener
    |--------------------------------------------------------------------------
    |
    | Here you may configure the list of events
    |
    */
    'events' => '*',
];
