<?php

declare(strict_types=1);

namespace App\Users\Application\Command\ImportUsers;

use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Application\Command\CreateUser\CreateUserCommand;
use App\Users\Application\Exception\ImportUsersException;
use League\Csv\Reader;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Ulid;

final class ImportUsersFromCsvHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly LoggerInterface $logger
    ) {
    }

    public function __invoke(ImportUsersFromCsvCommand $cmd): void
    {
        $csv = Reader::createFromPath($cmd->filePath);
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            try {
                if (! $this->isValidCsvRow($record)) {
                    throw new ImportUsersException('Invalid CSV row format');
                }

                $id = Ulid::generate();
                $email = (string) $record['email'];
                $password = (string) $record['password'];

                $this->commandBus->handle(
                    new CreateUserCommand($id, $email, $password)
                );
            } catch (\Throwable $e) {
                $this->logger->warning($e->getMessage());
            }
        }
    }

    private function isValidCsvRow(array $record): bool
    {
        return isset($record['email'], $record['password']) && count($record) === 2;
    }
}
