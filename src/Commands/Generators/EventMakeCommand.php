<?php

namespace Pravodev\Laramoud\Commands\Generators;

use Illuminate\Foundation\Console\ConsoleMakeCommand as BaseConsoleMakeCommand;
use Pravodev\Laramoud\Contracts\GeneratorTrait;

class EventMakeCommand extends BaseConsoleMakeCommand
{
    use GeneratorTrait;
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laramoud-make:event';

    
}