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

namespace Pravodev\Laramoud\Contracts;

use Illuminate\Support\Facades\Route;

trait Resource
{
    /**
     * Load View by namespace of module.
     *
     * @return void
     */
    public function loadViews($module_name)
    {
        $path = $this->getModulePath($module_name);
        $namespace = $module_name;
        $this->loadViewsFrom($path, $namespace);
    }

    /**
     * Load Routes.
     *
     * @return void
     */
    public function loadRoutes($module_name)
    {
        foreach (['web', 'api'] as $route_file) {
            $path = $this->getModulePath($module_name.'/routes/'.$route_file.'.php');
            if (file_exists($path) == false) {
                continue;
            }
            $namespace = $this->getNamespace($module_name, 'Http\Controllers');
            $route = Route::middleware($route_file)->namespace($namespace);

            if ($route_file == 'api') {
                $route->prefix($route_file);
            }

            $route->group($path);
        }
    }

    /**
     * Load Migrations.
     */
    public function loadMigrations($module_name)
    {
        $path = $this->getModulePath($module_name.'/database/migrations');
        $this->loadMigrationsFrom($path, $path);
    }

    /**
     * Get Module Namespace.
     *
     * @return string
     */
    public function getNamespace($module_name, $name = '')
    {
        $namespace = ucwords($module_name);

        return $namespace.'\\'.$name;
    }
}
