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

use Illuminate\Support\ServiceProvider;
use Pravodev\Laramoud\Contracts\RegisterCommand;
use Pravodev\Laramoud\Contracts\Resource;
use Pravodev\Laramoud\Contracts\Module;

class LaramoudServiceProvider extends ServiceProvider
{
    use RegisterCommand, Resource, Module;
    
    public function __construct($app)
    {
        parent::__construct($app);
        $this->cacheInit();
    }
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

        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }

        $this->loadModules();
    }

    /**
     * Load View Routes Migration & OBservers of Module.
     *
     * @return void
     */
    public function loadModules()
    {
        foreach ($this->getListOfModules() as $module) {
            $this->loadViews($module);
            $this->loadRoutes($module);
            $this->loadMigrations($module);
        }
    }
}
