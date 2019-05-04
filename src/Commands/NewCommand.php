<?php

namespace Pravodev\Laramoud\Commands;

use Illuminate\Console\Command;
use ZipArchive;
use RuntimeException;
use GuzzleHttp\Client;
use Pravodev\Laramoud\Contracts\Module;
use Illuminate\Support\Str;

class NewCommand extends Command
{
    use Module;
    public function __construct()
    {
        parent::__construct();

        $this->cacheInit();
    }
    
    /**
     * The name and signature of the console command.
     * 
     * @var string
     */
    protected $signature = 'laramoud:new {module_name} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create new module';

    /**
     * Execute the console command.
     *
     * @param  \App\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        $this->checkRequirement();

        $directory = $this->argument('module_name') ? $this->getModulePath().$this->argument('module_name') : getcwd();
        if(!$this->option('force')){
            // $this->verifyApplicationDoesntExist($directory);
        }

        $this->info('Crafting module...');

        if(!$this->cache->get('laramoud', 'scaffold')){
            $this->download($zipFile = $this->makeFileName(), $this->getVersion(), true);
        }

        $this->extractTo($directory)
             ->changeModuleComposer($directory, $this->argument('module_name'))
             ->addModuleToBaseComposer($directory);
        
        dd($directory);

    }

    protected function checkRequirement()
    {
        if(!extension_loaded('zip')){
            throw new RuntimeException('The Zip PHP extension is not installed. Please install it and try again.');
        }
    }

    /**
     * Download the temporary Zip to the given file.
     *
     * @param  string  $zipFile
     * @param  string  $version
     * @return $this
     */
    protected function download($zipFile, $version = 'master', $cache = true)
    {
        switch ($version) {
            case 'develop':
                $filename = 'latest-develop.zip';
                break;
            case 'master':
                $filename = 'latest.zip';
                break;
        }

        $response = (new Client)->get('http://laramoud.rifqiazam.com/download/'.$filename);
        $pathzipfile = $this->cache->path($zipFile);
        file_put_contents($pathzipfile, $response->getBody());
        $this->cache->set('laramoud', 'scaffold', $pathzipfile);
        return $this;
    }

    /**
     * Extract the Zip file into the given directory.
     *
     * @param  string  $zipFile
     * @param  string  $directory
     * @return $this
     */
    protected function extractTo($directory)
    {
        $archive = new ZipArchive;
        $archive->open($this->cache->get('laramoud', 'scaffold'));
        $archive->extractTo($directory);
        $archive->close();
        return $this;
    }

    /**
     * Clean-up the Zip file.
     *
     * @param  string  $zipFile
     * @return $this
     */
    protected function cleanUp($zipFile)
    {
        @chmod($zipFile, 0777);
        @unlink($zipFile);
        return $this;
    }
    

    protected function getVersion()
    {
        return 'master';
    }

    protected function makeFileName()
    {
        return 'laramoud_'.md5(time().uniqid()).'.zip';
    }

    public function changeModuleComposer($directory, $module_name)
    {
        $filename = $directory.'/composer.json';

        $description = $this->ask('Description ');
        
        $packageName = 'laramoud-module/'.$module_name;
        
        $composer = [
            'name' => $packageName,
            'description' => $description,
            'type' => 'laramoud-module',
            'require' => [
                "pravodev/laramoud-installer" => '^1.0'
            ],
            'autoload' => [
                'psr-4' => [
                    $this->getNamespace($module_name) => 'src/'
                ],
            ]
        ];
        

        return \file_put_contents($filename, json_encode($composer,JSON_PRETTY_PRINT));
    }

    public function addModuleToBaseComposer($directory)
    {
        
    }
    
    public function getNamespace($module_name)
    {
        return Str::studly($module_name).'\\';
    }

}