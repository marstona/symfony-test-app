<?php

declare(strict_types=1);

namespace App\Users\Application\Command\ImportUsers;

use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Application\Command\CreateUser\CreateUserCommand;
use App\Users\Application\Exception\ImportUsersException;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Ulid;
use Throwable;

final class ImportUsersFromCsvHandler implements CommandHandlerInterface
{
    /**
     * @param CommandBusInterface $commandBus
     * @param LoggerInterface     $logger
     */
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * @param  ImportUsersFromCsvCommand $command
     * @return void
     * @throws Exception
     * @throws UnavailableStream
     */
    public function __invoke(ImportUsersFromCsvCommand $command): void
    {
        $csv = $this->createCsvReader($command->filePath);

        foreach ($csv as $record) {
            try {
                if (! $this->isValidCsvRow($record)) {
                    throw new ImportUsersException('Invalid CSV row format');
                }

                $id = Ulid::generate();
                $email = (string) $record['email'];
                $password = (string) $record['password'];

                $this->commandBus->handle(
                    new CreateUserCommand($id, $email, $password),
                );
            } catch (Throwable $e) {
                $this->logger->warning($e->getMessage());
            }
        }

        unlink($command->filePath);
    }

    /**
     * @param  string            $filePath
     * @return Reader
     * @throws Exception
     * @throws UnavailableStream
     */
    private function createCsvReader(string $filePath): Reader
    {
        $csv = Reader::createFromPath($filePath);
        $csv->setHeaderOffset(0);

        return $csv;
    }

    /**
     * @param  array $record
     * @return bool
     */
    private function isValidCsvRow(array $record): bool
    {
        return isset($record['email'], $record['password']) && count($record) === 2;
    }
}
