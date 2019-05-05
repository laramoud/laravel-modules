<?php
/**
 * This file is part of laramoud package.
 * 
 * @author Rifqi Khoeruman Azam <pravodev@gmail.com>
 * 
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * Copyright © 2019 PondokIT. All rights reserved.
 */
namespace Pravodev\Laramoud\Contracts;

use Symfony\Component\Console\Input\InputArgument;
use Pravodev\Laramoud\Contracts\Module;
use \Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

trait GeneratorTrait
{
    use Module;

    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
        $this->cacheInit();
    }
    
    protected function getArguments()
    {
        return array_merge([
            ['module_name', InputArgument::REQUIRED, 'The module name']
        ], parent::getArguments());
    }

    protected function rootNamespace()
    {
        $module_name = $this->argument('module_name');
        return $this->getModuleNamespace($module_name);
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
        return $path;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        return $this->getModulePath($this->argument('module_name')).'/src/'.str_replace('\\', '/', $name).'.php';
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            ['DummyNamespace', 'DummyRootNamespace', 'NamespacedDummyUserModel'],
            [$this->getNamespace($name), 'App\\', $this->userProviderModel()],
            $stub
        );
        return $this;
    }
}