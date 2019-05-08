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

if(!function_exists('module_exists')){
    /**
     * Check module exist
     * 
     * @return bool
     */
    function module_exists($name){
        $path = __DIR__.'/../../cache/laramoud.php';
        if(!file_exists($path)){
            return false;
        }

        $laramoud = include($path);
        return in_array($name, $laramoud['modules']);
    }
}