<?php

namespace Pravodev\Laramoud;

use Illuminate\Support\Facades\Route;
use Pravodev\Laramoud\Providers\ModuleServiceProvider;

class LaramoudServiceProvider extends ModuleServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/laramoud.php' => \config_path('laramoud.php')
        ]);
        
        $this->loadModules();
    }
}
