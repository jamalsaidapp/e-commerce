<?php

namespace App\Providers;

use App\Services\CategoriesServices;
use App\Services\ServiceImpl\CategoriesServicesImpl;
use App\Services\ServiceImpl\UserServiceImpl;
use App\Services\UserService;
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
        $this->app->bind(UserService::class, function () {
            return new UserServiceImpl();
        });
        $this->app->bind(CategoriesServices::class, function () {
            return new CategoriesServicesImpl();
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
