<?php

namespace Pravodev\Laramoud\Commands\Generators;

use Illuminate\Database\Console\Seeds\SeederMakeCommand as BaseSeederMakeCommand;
use Pravodev\Laramoud\Contracts\GeneratorTrait;
use Illuminate\Filesystem\Filesystem;
use \Illuminate\Support\Composer;

class SeederMakeCommand extends BaseSeederMakeCommand
{
    use GeneratorTrait;

    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct($files, $composer);
        $this->cacheInit();
        $this->composer = $composer;
    }
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laramoud-make:seeder';

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return $this->getModulePath($this->argument('module_name')).'/database/seeds/'.$name.'.php';
    }
}
