<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */


return [
    'db' => [
        'driver'   => 'Pdo',
        'dsn'      => 'mysql:host=192.168.99.99',
        'username' => 'root',
        'password' => '123',
        'port'     => 3306,
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"
        ],
    ],

    'service_manager' => [
        'factories' => [
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ],
    ],
];