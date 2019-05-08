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
use Illuminate\Support\Facades\Blade;

class LaramoudServiceProvider extends ServiceProvider
{
    use RegisterCommand, Resource, Module;
    
    public function __construct($app)
    {
        parent::__construct($app);
        $this->cacheInit();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $file = __DIR__.'/Utils/Helper.php';
        if (file_exists($file)) {
            require_once($file);
        }
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
        $this->addBladeDirective();
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
    /**
     * Extends Blade directive.
     * 
     * @return void
     */
    public function addBladeDirective()
    {
        $directives = [
            'hasmodule' => function($name){
                return "<?php if (module_exists($name)) { ?>";
            },
            'donthavemodule' => function($name){
                return "<?php if (module_exists($name) === false) { ?>";
            }
        ];

        foreach ($directives as $name => $expression) {
            Blade::directive($name, $expression);
            Blade::directive('end'.$name, function(){
                return "<?php } ?>";
            });
        }
    }
}
