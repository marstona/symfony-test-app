<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Database\Doctrine\Types;

use App\Shared\Domain\ValueObject\UlidValue;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class UlidValueType extends Type
{
    public const NAME = 'ulid_value';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): UlidValue
    {
        return UlidValue::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->toString();
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
