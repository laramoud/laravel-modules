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

trait RegisterCommand
{
    protected $commands = [
        \Pravodev\Laramoud\Commands\NewCommand::class,
        \Pravodev\Laramoud\Commands\ClearCommand::class,
        \Pravodev\Laramoud\Commands\Generators\ControllerMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\EventMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\ExceptionMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\FactoryMakeCommand::class,
    ];

    public function registerCommands()
    {
        $this->commands($this->commands);
    }
}