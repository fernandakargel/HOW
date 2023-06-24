<?php

define("APPLICATION_ENV", "production");

define("SYS_URL", "http://".$_SERVER["SERVER_NAME"]."/");

define("SYS_USER_ROLES", json_encode(array("guess"=>"Visitante","user"=>"Usuário","manager"=>"Gestor","admin"=>"Administrador")));

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'determineRouteBeforeAppMiddleware' => true,
        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/Templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../storage/logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        
        // MySQL settings
        
        'db' => [
            'host' => 'localhost',
            'user' => 'root',
            'pass' => 'root',
            'dbname' => 'database_name',
        ],
            //DEV
            // 'db' => [
            //     'host' => 'localhost',
            //     'user' => 'root',
            //     'pass' => 'root',
            //     'dbname' => 'database_name',
            // ],

        
        'twing' => [
            "debug" => TRUE,
            "cache" => FALSE,
        ],
    ],
];
