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
        'system_manager' => [
            'admins' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'settings' => 'c,r,u,d',
            'profile' => 'r,u',
            'change-password' => 'r,u',

            'blogs' => 'c,r,u,d',
            'why-choose-us' => 'c,r,u,d',
            'client-reviews' => 'c,r,u,d',
            'consultation-requests' => 'r,d',
            'faqs' => 'c,r,u,d',

        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
