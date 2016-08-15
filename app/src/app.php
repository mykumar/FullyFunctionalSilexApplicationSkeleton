<?php

use App\Providers\CapsuleServiceProvider;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new Restio\CapsuleServiceProvider());

$app['twig'] = $app->extend('twig', function ($twig, $app) {

    // add custom globals, filters, tags, ...
    return $twig;
});

return $app;
