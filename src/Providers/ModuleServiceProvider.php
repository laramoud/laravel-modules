<?php

namespace Pravodev\Laramoud\Providers;

use Illuminate\Support\ServiceProvider;
use Pravodev\Laramoud\Contracts\Resource;
use Pravodev\Laramoud\Utils\Cache;

abstract class ModuleServiceProvider extends ServiceProvider
{
    use Resource;

    protected $cache;

    public function __construct($app)
    {
        parent::__construct($app);

        $this->cache = new Cache();
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

    /**
     * List Directory Modules.
     *
     * @return array
     */
    public function getListOfModules()
    {
        if ($modules = $this->cache->get('laramoud', 'modules')) {
            return $modules;
        }

        $module_path = $this->getModulePath();

        if (file_exists($module_path) == false) {
            return [];
        }

        $modules = array_values(
            array_diff(
                scandir($this->getModulePath(), 1),
                ['..', '.']
            )
        );

        $this->cache->set('laramoud', compact('modules'));

        return $modules;
    }

    public function getModulePath($name = '')
    {
        if ($config = $this->getConfig('module_path', 'composer')) {
            return base_path($config.$name);
        }

        return base_path('modules/'.$name);
    }

    /**
     * Get Laramoud Config.
     *
     * @return any
     */
    public function getConfig($key = null, $source = null)
    {
        if ($source == 'composer') {
            $config = $this->getComposer();

            return $config['extra']['laramoud'][$key] ?? null;
        }

        if (empty($key)) {
            return config('laramoud');
        }

        return config('laramoud.'.$key);
    }

    public function getComposer()
    {
        if ($composer = $this->cache->get('composer')) {
            return $composer;
        }
        // dd(as);
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $this->cache->set('composer', $composer);

        return $composer;
    }
}
