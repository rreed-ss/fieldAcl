<?php

return [
    'route' => [
        'prefix' => 'permissions'
        //   'middleware' => 'auth'
    ],
    'table' => 'fieldacl_permissions',
    'role_column' => 'role',
    'roles' => [
        'admin', 'client', 'merchant'
    ],
    /**
     * Classes to get table for
     */
    'classes' => [
        \App\User::class
    ]
];