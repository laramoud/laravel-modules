<?php

namespace Pravodev\Laramoud\Commands\Generators;

use Illuminate\Foundation\Console\ExceptionMakeCommand as BaseExceptionMakeCommand;
use Pravodev\Laramoud\Contracts\GeneratorTrait;

class ExceptionMakeCommand extends BaseExceptionMakeCommand
{
    use GeneratorTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laramoud-make:exception';
}
