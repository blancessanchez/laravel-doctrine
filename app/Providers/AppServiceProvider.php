<?php

namespace App\Providers;

use App\Entities\School;
use App\Entities\Student;
use App\Repositories\SchoolRepository;
use App\Repositories\StudentRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StudentRepository::class, function ($app) {
            return new StudentRepository(
                $app['em'],
                $app['em']->getClassMetaData(Student::class)
            );
        });

        $this->app->bind(SchoolRepository::class, function ($app) {
            return new SchoolRepository(
                $app['em'],
                $app['em']->getClassMetaData(School::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
