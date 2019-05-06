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

class Laramoud
{
    public function __construct()
    {
        $this->app = app();
    }

    public function getModulePath()
    {
    }

    public function getConfig()
    {
        return $this->app->config('laramoud.');
    }
}
