<?php

declare(strict_types=1);

namespace App\Shared\Application\Command;

interface CommandBusInterface
{
    /**
     * @param  CommandInterface $command
     * @return void
     */
    public function handle(CommandInterface $command): void;
}
