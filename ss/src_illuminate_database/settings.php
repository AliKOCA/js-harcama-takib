<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],
         // Database connection settings           
          "db" => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'asg_hss',
            'username' => 'root',
            'password' => 'Maria55',
            'charset'   => 'utf8',
            'collation' => 'utf8_turkish_ci',
            'prefix'    => '',
        ],
    ],
];

