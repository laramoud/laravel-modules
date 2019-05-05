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

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $stub = null;
        if ($this->option('model')) {
            $stub = '/stubs/controller.model.stub';
        } elseif ($this->option('invokable')) {
            $stub = '/stubs/controller.invokable.stub';
        } elseif ($this->option('resource')) {
            $stub = '/stubs/controller.stub';
        }
        if ($this->option('api') && is_null($stub)) {
            $stub = '/stubs/controller.api.stub';
        } elseif ($this->option('api') && ! is_null($stub) && ! $this->option('invokable')) {
            $stub = str_replace('.stub', '.api.stub', $stub);
        }
        $stub = $stub ?? '/stubs/controller.nested.stub';
        return base_path('vendor/laravel/framework/src/Illuminate/Routing/Console'.$stub);
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $controllerNamespace = $this->getNamespace($name);
        $replace = [
            $this->buildParentReplacements()
        ];
        
        if ($this->option('model')) {
            $replace = $this->buildModelReplacements($replace);
        }
        $replace["use {$controllerNamespace}\Controller;\n"] = '';
        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }
}   