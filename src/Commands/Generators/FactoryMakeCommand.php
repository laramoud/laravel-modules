<?php

namespace Pravodev\Laramoud\Commands\Generators;

use Illuminate\Database\Console\Factories\FactoryMakeCommand as BaseFactoryMakeCommand;
use Pravodev\Laramoud\Contracts\GeneratorTrait;

class FactoryMakeCommand extends BaseFactoryMakeCommand
{
    use GeneratorTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laramoud-make:factory';

    /**
     * Get the destination class path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace(
            ['\\', '/'], '', $this->argument('name')
        );

        return $this->getModulePath($this->argument('module_name'))."/database/factories/{$name}.php";
    }
}
