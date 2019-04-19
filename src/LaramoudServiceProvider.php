<?php

namespace Laramoud\Providers;

use Illuminate\Support\Facades\Route;
use Laramoud\Providers\ModuleServiceProvider;

class LaramoudServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        if($this->isAutoloadNamespaces()){
            $this->autoloadNamespaces();
        }

        $this->loadModules();
    }
}
