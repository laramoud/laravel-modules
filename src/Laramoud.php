<?php

namespace Pravodev\Laramoud;

class Laramoud 
{
    public function __construct()
    {
        $this->app = app();
    }

    public function getModulePath()
    {

    }

    public function getConfig()
    {
        return $this->app->config('laramoud.');
    }
}