<?php

namespace Detective\Testing;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /**
     * Boots the application
     *
     * @return \Illuminate\Foundation\Application
     */
     public function createApplication()
     {
         $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

         $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

         return $app;
     }

     /**
     * Setup DB before each test.
     *
     * @return void
     */
     public function setUp()
     {
         parent::setUp();

         $this->app['config']->set('database.default','sqlite');
         $this->app['config']->set('database.connections.sqlite.database', ':memory:');
         $this->migrate();
         $this->seed('Detective\Testing\Database\Seeders\DatabaseSeeder');
     }

     /**
     * run package database migrations
     *
     * @return void
     */
     public function migrate()
     {
         $fileSystem = new \Illuminate\Filesystem\Filesystem;
         $classFinder = new \Illuminate\Filesystem\ClassFinder;

         foreach($fileSystem->files(__DIR__ . "/Database/migrations") as $file)
         {
             $fileSystem->requireOnce($file);
             $migrationClass = $classFinder->findClass($file);

             (new $migrationClass)->up();
         }
     }
}
