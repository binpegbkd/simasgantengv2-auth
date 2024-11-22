<?php

$host1 = env('DB_HOST1');
$dbname1 = env('DB_NAME1');
$port1 = env('DB_PORT1');
$username1 = env('DB_USER1');
$password1 = env('DB_PASS1');

$db = [
    'db1' => [
        'class' => 'yii\db\Connection',
        'dsn' => "pgsql:host=$host1;dbname=$dbname1;port=$port1",
        'username' => $username1,
        'password' => $password1,
        'charset' => 'utf8',
        'schemaMap' => [
            'pgsql' => [
                'class' => 'yii\db\pgsql\Schema',
                'defaultSchema' => 'public' 
            ],
        ],
        'enableSchemaCache' => true,  
        'schemaCacheDuration' => 60,
        'schemaCache' => 'cache',
    ],
];

return $db;
