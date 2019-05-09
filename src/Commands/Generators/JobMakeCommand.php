<?php

namespace Laramoud\Modules\Commands\Generators;

use Illuminate\Foundation\Console\JobMakeCommand as BaseJobMakeCommand;
use Laramoud\Modules\Contracts\GeneratorTrait;

class JobMakeCommand extends BaseJobMakeCommand
{
    use GeneratorTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laramoud-make:job';
}
