<?php

namespace Pravodev\Laramoud\Providers;

use Illuminate\Support\ServiceProvider;

abstract class ModuleServiceProvider extends ServiceProvider
{
    private $modules = [];
    
    public function boot()
    {
        // $this->modules = $this->getModulesDir();
    }

    public function register(){}

    
    /**
     * 
     */
    public function isAutoloadNamespaces()
    {
        return $this->getConfig('spl_autoload');
    }


    /**
     * 
     * 
     * @return void
     */
    public function autoloadNamespaces()
    {
        $module_path = $this->getConfig('module_path');

        spl_autoload_register(function($className)use($module_path){
            include_once $module_path . '/' . $className . '.php';
        });
    }

    /**
     * Load View Routes Migration & OBservers of Module
     * 
     * @return void
     */
    public function loadModules()
    {
        foreach($this->getModulesDir() as $module){
            $this->loadViews($module);
            $this->loadRoutes($module);
            $this->loadMigrations($module);
            $this->loadObservers($module);
        }
    }

    /**
     * Load View by namespace of module
     * 
     * @return void
     */
    public function loadViews($module_name)
    {
        
    }

    /**
     * List Directory Modules
     * 
     * @return array
     */
    public function getModulesDir()
    {
        if(empty($this->modules)){
            $this->modules = array_values(
                array_diff(
                    scandir($this->getConfig('module_path'), 1),
                    array('..', '.')
                )
            );
        }

        return $this->modules;
    }
    
    /**
     * Get Laramoud Config
     * 
     * @return any
     */
    public function getConfig($key = null)
    {
        if(empty($key)){
            return config('laramoud');
        }

        return config('laramoud.' . $key);
    }
}