<?php

namespace Laramoud\Modules\Commands\Generators;

use Illuminate\Foundation\Console\ChannelMakeCommand as BaseChannelMakeCommand;
use Laramoud\Modules\Contracts\GeneratorTrait;

class ChannelMakeCommand extends BaseChannelMakeCommand
{
    use GeneratorTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laramoud-make:channel';
}
