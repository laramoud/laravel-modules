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

use Pravodev\Laramoud\Utils\Cache;

trait Module
{
    protected $cache;

    public function cacheInit()
    {
        $this->cache = new Cache();
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