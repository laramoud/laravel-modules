<?php

namespace Pravodev\Laramoud\Commands\Migrations;

use Illuminate\Console\Command;
use Pravodev\Laramoud\Contracts\Module;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SeedCommand extends Command
{
    use Module;
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laramoud:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with records';
    
    /**
     * Create a new migration command instance.
     *
     * @param  \Illuminate\Database\Migrations\Migrator  $migrator
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->cacheInit();
    }
    
    /**
     *  Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if(file_exists($this->getModulePath($this->argument('module_name')).'/') == false){
            $this->error('module with name '. $this->argument('module_name').' not found');
            return;
        }
        
        $this->call('db:seed', [
            '--class' => $this->getModuleSeederClass(),
            '--database' => $this->option('database'),
            '--force' => $this->option('force')
        ]);
    }

    /**
     * Get ModuleSeeder Class
     * 
     * @return string
     */
    public function getModuleSeederClass()
    {
        return $this->option('class') ?: str_replace('\\', '', $this->getModuleNamespace($this->argument('module_name'))).'Seeder';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module_name', InputArgument::REQUIRED, 'The module name'],

        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['class', null, InputOption::VALUE_OPTIONAL, 'The class name of the root seeder [default: "{ModuleName}Seeder"]'],

            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to seed'],

            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production'],
        ];
    }

    
}