<?php

namespace Pravodev\Laramoud\Commands\Generators;

use Illuminate\Foundation\Console\ListenerMakeCommand as BaseListenerMakeCommand;
use Pravodev\Laramoud\Contracts\GeneratorTrait;

class ListenerMakeCommand extends BaseListenerMakeCommand
{
    use GeneratorTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laramoud-make:listener';
}
