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

namespace Laramoud\Modules\Contracts;

trait RegisterCommand
{
    protected $commands = [
        \Laramoud\Modules\Commands\NewCommand::class,
        \Laramoud\Modules\Commands\ClearCommand::class,

        // List all generator commands
        \Laramoud\Modules\Commands\Generators\ChannelMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\ControllerMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\EventMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\ExceptionMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\FactoryMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\JobMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\ListenerMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\MailMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\MiddlewareMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\MigrateMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\ModelMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\MigrateMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\NotificationMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\ObserverMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\PolicyMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\ProviderMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\RequestMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\ResourceMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\RuleMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\SeederMakeCommand::class,
        \Laramoud\Modules\Commands\Generators\TestMakeCommand::class,

        // List all migration command
        \Laramoud\Modules\Commands\Migrations\MigrateCommand::class,
        \Laramoud\Modules\Commands\Migrations\SeedCommand::class,
    ];

    public function registerCommands()
    {
        $this->commands($this->commands);
    }
}
