<?php

namespace Pravodev\Laramoud\Commands\Generators;

use Illuminate\Routing\Console\MiddlewareMakeCommand as BaseMiddlewareMakeCommand;
use Pravodev\Laramoud\Contracts\GeneratorTrait;

class MiddlewareMakeCommand extends BaseMiddlewareMakeCommand
{
    use GeneratorTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laramoud-make:middleware';
}
