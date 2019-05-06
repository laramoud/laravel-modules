<?php

namespace Pravodev\Laramoud\Commands\Generators;

use Illuminate\Foundation\Console\MailMakeCommand as BaseMailMakeCommand;
use Pravodev\Laramoud\Contracts\GeneratorTrait;

class MailMakeCommand extends BaseMailMakeCommand
{
    use GeneratorTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laramoud-make:mail';

    /**
     * Write the Markdown template for the mailable.
     *
     * @return void
     */
    protected function writeMarkdownTemplate()
    {
        $path = $this->getModulePath($this->argument('module_name')).'/resources/views/'.str_replace('.', '/', $this->option('markdown')).'.blade.php';

        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }

        $vendor = base_path('vendor/laravel/framework/src/Illuminate/Foundation/Console');

        $this->files->put($path, file_get_contents($vendor.'/stubs/markdown.stub'));
    }

     /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        $class = $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
        if ($this->option('markdown')) {
            $class = str_replace('DummyView', $this->argument('module_name').'::'.$this->option('markdown'), $class);
        }
        return $class;
    }
}
