<?php

namespace Pravodev\Laramoud\Commands\Generators;

use Illuminate\Foundation\Console\ProviderMakeCommand as BaseProviderMakeCommand;
use Pravodev\Laramoud\Contracts\GeneratorTrait;

class ProviderMakeCommand extends BaseProviderMakeCommand
{
    use GeneratorTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laramoud-make:provider';
}
