<?php
namespace App\Providers;

use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Database\Capsule\Manager as Capsule;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Application;

class CapsuleServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    /**
     * Register the Capsule service.
     *
     * @param Container|Application $app
     */
    public function register(Container $app)
    {
        $app['capsule.connection'] = [
            'default' => [
                'driver'    => "mysql",
                'host'      => "localhost",
                'database'  => "test_db",
                'username'  => "root",
                'password'  => "",
                'charset'   => "utf8",
                'collation' => "utf8_unicode_ci",
                'prefix'    => null,
                'logging'   => false,
            ]
        ];

        $app['capsule.container'] = $app->protect(function () {
            return new IlluminateContainer();
        });

        $app['capsule'] = $app->factory(function ($app) {
            $capsule = new Capsule();
            $capsule->addConnection($app['capsule.connection']['default']);
            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            return $capsule;
        });
    }

    /**
     * Boot the Capsule service.
     *
     * @param Application $app ;
     **/
    public function boot(Application $app)
    {
        $app->before(function () use ($app) {
            return $app['capsule'];
        }, Application::EARLY_EVENT);
    }
}