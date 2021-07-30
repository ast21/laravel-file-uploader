<?php

namespace Aebitdev\FileUploader;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class FileUploaderServiceProvider extends BaseServiceProvider
{

    public function register()
    {
        $this->registerConfig();
    }

    public function boot()
    {
        $this->registerRoutes();
    }

    public function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'file-uploader');
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
}