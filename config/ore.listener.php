<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    |
    | This is the table used to save works to the database
    |
    */
    'table' => 'ore_listeners',

    'events' => [
        'Railken\LaraOre*',
    ],

    'router' => [
        'prefix'      => 'admin/listeners',
        'middlewares' => [
            \Railken\LaraOre\RequestLoggerMiddleware::class,
            'auth:api',
        ],
    ],
];
