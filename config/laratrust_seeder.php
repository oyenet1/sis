<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadministrator' => [
            'users' => 'c,r,u,d',
            'payments' => 'c,r,u,d',
            'profiles' => 'c,r,u,d',
            'messages' => 'c,r,u,d',
            'dashboard' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'permissions' => 'c,r,u,d',
            'subjects' => 'c,r,u,d',
            'lessons' => 'c,r,u,d',
            'visitors' => 'c,r,u,d',
            'fees' => 'c,r,u,d',
            'department' => 'c,r,u,d',
            'club' => 'c,r,u,d',
            'leave' => 'c,r,u,d',
            'students' => 'c,r,u,d',
        ],
        'admin' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'teacher' => [
            'users' => 'c,r,u,d',
            'payments' => 'c,r,u,d',
            'profile' => 'c,r,u,d'
        ],
        'class teacher' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'hod' => [
            'users' => 'c,r,u,d',
            'payments' => 'c,r,u,d',
            'profile' => 'c,r,u,d'
        ],
        'hos' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'founder' => [
            'users' => 'c,r,u,d',
            'payments' => 'c,r,u,d',
            'profile' => 'c,r,u,d'
        ],
        'exam officer' => [
            'users' => 'c,r,u,d',
            'payments' => 'c,r,u,d',
            'profile' => 'c,r,u,d'
        ],
        'president' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'parent' => [
            'users' => 'c,r,u,d',
            'payments' => 'c,r,u,d',
            'profile' => 'c,r,u,d'
        ],
        'student' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'nurse' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'accountant' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ]
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];