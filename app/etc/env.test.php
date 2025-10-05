<?php
return [
    'params' => [
        'adminEmail' => 'admin@example.com',
        'apiVersion' => '1.0',
        'allowedOrigins' => ['http://localhost:3000', 'http://localhost:8080'],
    ],
    'debug' => true,
    'env' => 'dev',
    'timezone' => 'Europe/London',
    'language' => 'en-US',
    'mailer.host' => 'smtp.mailtrap.io',
    'mailer.username' => 'your_mailer_username',
    'mailer.password' => 'your_mailer_password',
    'mailer.file.transport' => true,
    'db.dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=your_db_name',
    'db.username' => 'your_db_username',
    'db.password' => 'your_db_password',
    'cookie.validation.key' => 'your_cookie_validation_key_change_this',
];