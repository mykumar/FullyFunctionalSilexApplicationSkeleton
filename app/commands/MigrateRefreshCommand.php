<?php

namespace App\Command;

use Illuminate\Database\Capsule\Manager;
use Silex\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateRefreshCommand extends Command
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
            ->setName('migrate:refresh')
            ->setDescription('Refresh all migrations');
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
        // Down
        foreach ($migration_classes as $k => $class) {
            try {
                $class->down($this->app);
                $output->writeln("Rollback: " . $migration_basenames[$k]);
            } catch (\Exception $e) {
                $output->writeln("Non Rollback: " . $migration_basenames[$k] . " exception: " . $e->getMessage());
            }
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