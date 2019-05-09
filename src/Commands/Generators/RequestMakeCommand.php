<?php

namespace Laramoud\Modules\Commands\Generators;

use Illuminate\Foundation\Console\RequestMakeCommand as BaseRequestMakeCommand;
use Laramoud\Modules\Contracts\GeneratorTrait;

class RequestMakeCommand extends BaseRequestMakeCommand
{
    use GeneratorTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laramoud-make:request';
}
