<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Ziggy Configuration file
    |--------------------------------------------------------------------------
    */

    'except' => ['debugbar.*', 'horizon.*'],

    'groups' => [
        'guest' => [
            'locale.set',
            'guest.*',
            // load all guest routes here
        ],
        'admin' => [
            // load all admin prefixed routes here
            'admin.*',
            'profile.*',
            'api.*',
        ],
    ],

];
