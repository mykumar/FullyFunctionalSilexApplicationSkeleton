<?php
// configure your app for the production environment
$app['twig.path']    = [__DIR__ . '/../templates'];
$app['twig.options'] = ['cache' => __DIR__ . '/../../var/cache/twig'];
// configure Eloquent Capsule
$app['capsule.connection'] = ['default' => [
    "driver"    => "mysql",
    "host"      => "localhost",
    "database"  => "silex",
    "username"  => "root",
    "password"  => "",
    "charset"   => "utf8",
    "collation" => "utf8_unicode_ci",
    "prefix"    => null,
    "logging"   => false,
]];
$app['migrations.path']    = __DIR__ . '/../../database/migrations/';