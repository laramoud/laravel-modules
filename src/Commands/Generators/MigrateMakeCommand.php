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
namespace Pravodev\Laramoud\Commands\Generators;

use Illuminate\Console\Command;
use Pravodev\Laramoud\Contracts\Module;

class MigrateMakeCommand extends Command
{
    use Module;

    public function __construct()
    {
        parent::__construct();
        $this->cacheInit();
    }

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'laramoud-make:migration {module_name : The module name} {name : The name of the migration}
        {--create= : The table to be created}
        {--table= : The table to migrate}
        {--path= : The location where the migration file should be created}
        {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration file';

    public function handle()
    {
        $this->call('make:migration', [
            'name' => $this->argument('name'),
            '--create' => $this->option('create'),
            '--table' => $this->option('table'),
            '--path' => $this->getMigrationPath(),
            '--realpath' => $this->option('realpath')
        ]);
    }

     /**
     * Get migration path (either specified by '--path' option or default location).
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        $path = $this->option('path') ?: '/database/migrations';
        $module_path = $this->getConfig('module_path', 'composer') ?: 'modules/';
        return $module_path.$this->argument('module_name').$path;
    }
}
