<?php

namespace Laramoud\Modules\Commands\Generators;

use Illuminate\Foundation\Console\TestMakeCommand as BaseTestMakeCommand;
use Illuminate\Support\Str;
use Laramoud\Modules\Contracts\GeneratorTrait;

class TestMakeCommand extends BaseTestMakeCommand
{
    use GeneratorTrait;

    protected $signature = 'laramoud-make:test {module_name : The module name} {name : The name of the class} {--unit : Create a unit test}';

    /**
     * Get the destination class path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->getModulePath($this->argument('module_name').'/tests').str_replace('\\', '/', $name).'.php';
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return parent::rootNamespace().'Tests';
    }
}
