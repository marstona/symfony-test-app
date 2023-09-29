<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Doctrine\Types;

use App\Shared\Domain\ValueObject\UlidValue;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class UlidValueType extends Type
{
    public const NAME = 'ulid_value';

    /**
     * @param                   $value
     * @param  AbstractPlatform $platform
     * @return string
     */
    /**
     * @param                   $value
     * @param  AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->toString();
    }

    /**
     * @param                   $value
     * @param  AbstractPlatform $platform
     * @return UlidValue
     */
    /**
     * @param                   $value
     * @param  AbstractPlatform $platform
     * @return UlidValue
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): UlidValue
    {
        return UlidValue::fromString($value);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param  array            $column
     * @param  AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }
}
