<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\Contracts\DataReader;
use App\Library\Services\Readers\JsonApiReader;
use App\Library\Services\Readers\FileReader;

class ReaderServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\Contracts\DataReader', function ($app) {
            // return new JsonApiReader();
            return new FileReader();
        });
    }
}
