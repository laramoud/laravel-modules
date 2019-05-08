<?php

namespace Pravodev\Laramoud\Commands\Migrations;

use Illuminate\Console\Command;
use Pravodev\Laramoud\Contracts\Module;

class MigrateCommand extends Command
{
    use Module;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laramoud:migrate {module_name : The module name} {--database= : The database connection to use}
                {--force : Force the operation to run when in production}
                {--path= : The path to the migrations files to be executed}
                {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths}
                {--pretend : Dump the SQL queries that would be run}
                {--seed : Indicates if the seed task should be re-run}
                {--step : Force the migrations to be run so they can be rolled back individually}';

    protected $description = 'Run the database migrations';

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
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if(file_exists($this->getModulePath($this->argument('module_name')).'/') == false){
            $this->error('module with name '. $this->argument('module_name').' not found');
            return;
        }

        $this->call('migrate', [
            '--database' => $this->option('database'),
            '--path' => $this->getMigrationPath(),
            '--realpath' => $this->option('realpath'),
            '--step' => $this->option('step')
        ]);

        if($this->option('seed')){
            $this->call('laramoud:seed');
        }
    }

    /**
     * get database migration path on modules.
     *
     * @return string
     */
    public function getMigrationPath()
    {
        $base = ($this->getConfig('module_path', 'composer') ?: 'modules/').$this->argument('module_name').'/';

        if($path = $this->option('path')){
            return $base.$path;
        }
        return $base.'database/migrations';
    }

    
}