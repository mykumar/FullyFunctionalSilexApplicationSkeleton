<?php

namespace App\Command;

use Silex\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateUpCommand extends Command
{
    public $app;

    public function __construct(Application $app)
    {
        parent::__construct();
        $this->app = $app;
    }

    protected function configure()
    {
        $this
            ->setName('migrate:up')
            ->setDescription('Up all migrations');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $migration_files = glob($this->app['migrations.path'] . "*.php");

        $migration_classes   = [];
        $migration_basenames = [];
        // Load and register all classes
        foreach ($migration_files as $k => $migrateClass) {
            require $migrateClass;

            $class                   = preg_replace("~^\d+_|\.php~", "", basename($migrateClass));
            $migration_basenames[$k] = basename($migrateClass);
            $migration_classes[$k]   = new $class();
        }
        // Up
        foreach ($migration_classes as $k => $class) {
            try {
                $class->up($this->app);
                $output->writeln("Migrate: " . $migration_basenames[$k]);
            } catch (\Exception $e) {
                $output->writeln("Non Migrate: " . $migration_basenames[$k] . " exception: " . $e->getMessage());
            }
        }
    }
}