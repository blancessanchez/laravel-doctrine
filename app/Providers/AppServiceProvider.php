<?php

namespace App\Providers;

use App\Entities\District;
use App\Entities\School;
use App\Entities\Student;
use App\Repositories\DistrictRepository;
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
        $this->app->bind(DistrictRepository::class, function ($app) {
            return new DistrictRepository(
                $app['em'],
                $app['em']->getClassMetaData(District::class)
            );
        });

        $this->app->bind(SchoolRepository::class, function ($app) {
            return new SchoolRepository(
                $app['em'],
                $app['em']->getClassMetaData(School::class)
            );
        });

        $this->app->bind(StudentRepository::class, function ($app) {
            return new StudentRepository(
                $app['em'],
                $app['em']->getClassMetaData(Student::class)
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
