<?php

namespace Aebitdev\FileUploader;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class FileUploaderServiceProvider extends BaseServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'file-uploader');
    }

    public function boot()
    {
        $this->publishConfig();
        $this->registerRoutes();
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    public function routeConfiguration()
    {
        return [
            'prefix' => config('file-uploader.prefix'),
            'middleware' => config('file-uploader.middleware'),
        ];
    }

    public function publishConfig()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config/config.php' => config_path('file-uploader.php')], 'file-uploader');
        }
    }
}
