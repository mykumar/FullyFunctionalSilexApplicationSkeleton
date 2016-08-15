<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Silex\Application;

class CreateUsersTable extends Capsule
{
    /**
     * @param Application $app
     */
    public function up(Application $app)
    {
        $app['capsule']::schema()->create("users", function (Blueprint $blueprint) {

            $blueprint->increments("id");
            $blueprint->string("name", 12);
            $blueprint->string("email");
            $blueprint->timestamps();

        });
    }

    public function down(Application $app)
    {
        $app['capsule']::schema()->dropIfExists("users");
    }
}

