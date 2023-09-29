<?php

declare(strict_types=1);

namespace App\Users\Application\Query\FindUser;

use App\Shared\Application\Query\QueryInterface;
use App\Shared\Domain\ValueObject\UlidValue;

final readonly class FindUserQuery implements QueryInterface
{
    /**
     * @param UlidValue $id
     */
    public function __construct(
        public UlidValue $id,
    ) {
    }
}
