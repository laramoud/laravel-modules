<?php

namespace Laramoud\Modules\Commands\Generators;

use Illuminate\Foundation\Console\EventMakeCommand as BaseEventMakeCommand;
use Laramoud\Modules\Contracts\GeneratorTrait;

class EventMakeCommand extends BaseEventMakeCommand
{
    use GeneratorTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laramoud-make:event';
}
