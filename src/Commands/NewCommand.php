<?php

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
        if(!$this->option('force')){
            // $this->verifyApplicationDoesntExist($directory);
        }

        $this->info('Crafting module...');
        $this->download($zipFile = $this->makeFileName(), $this->getVersion(), true)
             ->extract(getcwd().'/laramoud_79a5d5baffa0f79b59a1cd842ab2381b.zip', $directory);
        dd($zipFile);
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

        if($cache){
            if($this->cache->get('laramoud', 'scaffold')){
                return $this;
            }
        }
        $this->cache->set('laramoud', ['scaffold' => $zipFile]);
        $response = (new Client)->get('http://laramoud.rifqiazam.com/download/'.$filename);
        file_put_contents($zipFile, $response->getBody());
        return $this;
    }

    /**
     * Extract the Zip file into the given directory.
     *
     * @param  string  $zipFile
     * @param  string  $directory
     * @return $this
     */
    protected function extract($zipFile, $directory)
    {
        $archive = new ZipArchive;
        $archive->open($zipFile);
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
        return getcwd().'/laramoud_'.md5(time().uniqid()).'.zip';
    }

}