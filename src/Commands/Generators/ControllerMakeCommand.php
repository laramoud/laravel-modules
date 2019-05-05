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

namespace Pravodev\Laramoud\Commands\Generators;

use Illuminate\Routing\Console\ControllerMakeCommand as BaseControllerMakeCommand;
use Pravodev\Laramoud\Contracts\GeneratorTrait;

class ControllerMakeCommand extends BaseControllerMakeCommand
{
    use GeneratorTrait;

    /**
     * The console command name
     * 
     * @var string
     */
    protected $name = 'laramoud-make:controller';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }
}   