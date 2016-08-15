<?php

use App\Command\MigrateCommand;
use App\Command\MigrateDownCommand;
use App\Command\MigrateRefreshCommand;
use App\Command\MigrateUpCommand;
use Symfony\Component\Console\Application;

/**
 * @var $app Silex\Application
 */
$console = new Application("My Silex Application", "0.1");
$console->add(new MigrateUpCommand($app));
$console->add(new MigrateDownCommand($app));
$console->add(new MigrateRefreshCommand($app));
return $console;
