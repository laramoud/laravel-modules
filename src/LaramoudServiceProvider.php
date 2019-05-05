<?php
/**
 * This file is part of laramoud package.
 * 
 * @author Rifqi Khoeruman Azam <pravodev@gmail.com>
 * 
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * Copyright © 2019 PondokIT. All rights reserved.
 */
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
