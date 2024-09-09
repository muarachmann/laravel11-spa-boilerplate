<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => false,

    'roles_structure' => [
        'owner' => [
            'users' => 'c,r,u,d,a,p',
        ],
        'admin' => [
            'users' => 'c,r,u,d,a,p',
        ],
         'user' => [
            'profile' => 'r,u',
         ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'p' => 'pin',
        'a' => 'approve',
    ]
];
