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

        // List all generator commands
        \Pravodev\Laramoud\Commands\Generators\ChannelMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\ControllerMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\EventMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\ExceptionMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\FactoryMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\JobMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\ListenerMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\MailMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\MiddlewareMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\MigrateMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\ModelMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\MigrateMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\NotificationMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\ObserverMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\PolicyMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\ProviderMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\RequestMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\ResourceMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\RuleMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\SeederMakeCommand::class,
        \Pravodev\Laramoud\Commands\Generators\TestMakeCommand::class,

        // List all migration command
        \Pravodev\Laramoud\Commands\Migrations\MigrateCommand::class,
        \Pravodev\Laramoud\Commands\Migrations\SeedCommand::class,
    ];

    public function registerCommands()
    {
        $this->commands($this->commands);
    }
}
