<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Console;

use App\Shared\Application\Command\CommandBusInterface;
use App\Users\Application\Command\CreateUser\CreateUserCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Uid\Ulid;
use Webmozart\Assert\Assert;

#[AsCommand(
    name: 'app:users:create-user'
)]
final class CreateUserConsoleCommand extends Command
{
    public function __construct(
        private readonly CommandBusInterface $commandBus
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $io->ask(
            'email',
            null,
            function (?string $input) {
                Assert::email($input, 'Email is invalid');

                return $input;
            }
        );

        $password = $io->askHidden(
            'password',
            function (?string $input) {
                Assert::notEmpty($input, 'Password cannot be empty');

                return $input;
            }
        );

        $ulid = Ulid::generate();
        $createUserCommand = new CreateUserCommand($ulid, $email, $password);
        $this->commandBus->handle($createUserCommand);

        return Command::SUCCESS;
    }
}
