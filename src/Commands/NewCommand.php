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

namespace Pravodev\Laramoud\Commands;

use Illuminate\Console\Command;
use ZipArchive;
use RuntimeException;
use GuzzleHttp\Client;
use Pravodev\Laramoud\Contracts\Module;

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

        if(!$this->option('force') ){
            $this->verifyModuleDoesntExist($directory);
        }

        
        if(!$this->cache->get('laramoud', 'scaffold')){
            $this->info('Crafting module...');
            $this->download($zipFile = $this->makeFileName(), $this->getVersion(), true);
        } else {
            $this->info('Crafting module from cache...');
        }

        $this->extractTo($directory)
            ->changeModuleComposer($directory, $this->argument('module_name'))
            ->addModuleToBaseComposer($directory);

        $this->info('install module '.$this->argument('module_name'). '...');
        $this->line('composer require laramoud-module/'.$this->argument('module_name'));
        shell_exec('composer require laramoud-module/'.$this->argument('module_name'));
        $this->line('Clearing cache...');
        $this->call('laramoud:clear');
        $this->info('Module ready! Build something amazing.');

    }

    public function verifyModuleDoesntExist($directory, $exception = false)
    {
        if(!file_exists($directory)) return true;
        
        throw new \Exception('Module with name of '. $this->argument('module_name') . ' already installed');
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
        $this->info('Preparing composer.json...');
        
        $filename = $directory.'/composer.json';

        $description = $this->ask('Description ');
        
        $packageName = 'laramoud-module/'.$module_name;
        
        $composer = [
            'name' => $packageName,
            'description' => $description,
            'type' => 'laramoud-module',
            'require' => [
                "pravodev/laramoud" => 'dev-develop'
            ],
            'autoload' => [
                'psr-4' => [
                    $this->getModuleNamespace($module_name) => 'src/'
                ],
            ]
        ];
        

        \file_put_contents($filename, json_encode($composer,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));

        return $this;
    }

    public function addModuleToBaseComposer($directory)
    {
        $this->info('add module to base composer');
        $filename = getcwd().'/composer.json';
        $composer = json_decode(\file_get_contents($filename), true);

        if(array_key_exists('repositories', $composer)){
            if(array_key_exists('type', $composer['repositories'])){
                $composer['repositories'] = [ $composer['repositories'] ];
            }
        }else{
            $composer['repositories'] = [];
        }

        $repositories = [
            [
                'type' => 'path',
                'url' => $directory,
                'options' => [
                    'symlink' => true
                ]
            ]
        ];

        $composer['repositories'] = array_merge($composer['repositories'], $repositories);
        \file_put_contents($filename, json_encode($composer, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
        return $this;
    }

}