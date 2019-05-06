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
use Pravodev\Laramoud\Contracts\Module;

class ClearCommand extends Command
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
    protected $signature = 'laramoud:clear {--scaffold} {--cache}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clear cache';

    /**
     * Execute the console command.
     *
     * @param \App\DripEmailer $drip
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('scaffold') || $this->doesntHaveOptions()) {
            $this->clearScaffold();
        }

        if ($this->option('cache') || $this->doesntHaveOptions()) {
            $this->clearCache();
        }
    }

    /**
     * Check command has option or no.
     *
     * @return bool
     */
    public function doesntHaveOptions()
    {
        return $this->option('cache') == false && $this->option('scaffold') == false;
    }

    /**
     * Clear Scaffolding of module.
     *
     * @return void
     */
    public function clearScaffold()
    {
        try {
            $filename = $this->cache->get('laramoud', 'scaffold');
            if (file_exists($filename)) {
                unlink($filename);
            }

            $current_cache = $this->cache->get('laramoud');
            unset($current_cache['scaffold']);
            $this->cache->set('laramoud', $current_cache);
            $this->info('Laramoud scaffold deleted');
        } catch (\Throwable $th) {
            $this->error('Laramoud scaffold failed to delete');
        }
    }

    public function clearCache()
    {
        try {
            $this->cache->clear();
            $this->info('Laramoud cache deleted');
        } catch (\Throwable $th) {
            $this->error('Laramoud cache failed to delete');
        }
    }
}
