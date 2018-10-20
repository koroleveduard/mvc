<?php

return [
    'components' => [
        'router' => [
            'className' => \App\Core\Component\Router\Router::class,
            'options' => []
        ],
        'db_driver' => [
            'className' => \App\Core\Component\Db\Mysql::class,
            'options' => [
                'username' => 'root',
                'password' => 1,
                'dbname' => 'mvc',
            ]
        ],
    ]
];
