<?php

namespace Pravodev\Laramoud;

use Pravodev\Laramoud\Providers\ModuleServiceProvider;

class LaramoudServiceProvider extends ModuleServiceProvider
{
    protected $commands = [
        \Pravodev\Laramoud\Commands\NewCommand::class
    ];
    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laramoud.php' => \config_path('laramoud.php'),
        ]);

        if($this->app->runningInConsole()){
            $this->commands($this->commands);
        }
        
        $this->loadModules();
    }
}
