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
            'model'      => Amethyst\Models\Listener::class,
            'schema'     => Amethyst\Schemas\ListenerSchema::class,
            'repository' => Amethyst\Repositories\ListenerRepository::class,
            'serializer' => Amethyst\Serializers\ListenerSerializer::class,
            'validator'  => Amethyst\Validators\ListenerValidator::class,
            'authorizer' => Amethyst\Authorizers\ListenerAuthorizer::class,
            'faker'      => Amethyst\Fakers\ListenerFaker::class,
            'manager'    => Amethyst\Managers\ListenerManager::class,
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
