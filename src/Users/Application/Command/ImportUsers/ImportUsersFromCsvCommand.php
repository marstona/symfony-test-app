<?php

declare(strict_types=1);

namespace App\Users\Application\Command\ImportUsers;

use App\Shared\Application\Command\AsyncCommandInterface;

final readonly class ImportUsersFromCsvCommand implements AsyncCommandInterface
{
    /**
     * @param string $filePath
     */
    public function __construct(
        public string $filePath,
    ) {
    }
}
