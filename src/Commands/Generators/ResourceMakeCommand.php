<?php

namespace Pravodev\Laramoud\Commands\Generators;

use Illuminate\Foundation\Console\ResourceMakeCommand as BaseResourceMakeCommand;
use Pravodev\Laramoud\Contracts\GeneratorTrait;

class ResourceMakeCommand extends BaseResourceMakeCommand
{
    use GeneratorTrait;
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laramoud-make:resource';
}
