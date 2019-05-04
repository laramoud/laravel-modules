<?php

namespace Pravodev\Laramoud\Providers;

use Illuminate\Support\ServiceProvider;
use Pravodev\Laramoud\Contracts\Resource;
use Pravodev\Laramoud\Contracts\Module;
use Pravodev\Laramoud\Utils\Cache;

abstract class ModuleServiceProvider extends ServiceProvider
{
    use Resource, Module;

    protected $cache;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->cacheInit();
    }

    public function boot()
    {
    }

    public function register()
    {
    }

    public function isAutoloadNamespaces()
    {
        return $this->getConfig('spl_autoload');
    }

    /**
     * @return void
     */
    public function autoloadNamespaces()
    {
        $module_path = $this->getConfig('module_path');

        spl_autoload_register(function ($className) use ($module_path) {
            include_once $module_path.'/'.$className.'.php';
        });
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
            // $this->loadObservers($module);
        }
    }
}
