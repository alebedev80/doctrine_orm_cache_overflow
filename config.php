<?php

return [
    'db' => [
        'driver' => 'pdo_mysql',
        'host' => 'mysql',
        'user' => 'root',
        'password' => 'root',
        'dbname' => 'mydatabase',
    ],
    'redis' => [
        'host' => 'redis',
        'port' => 6379,
        'database' => 0,
    ],
];