<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Database\Doctrine\Types;

use App\Users\Domain\ValueObject\EmailValue;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class EmailValueType extends Type
{
    public const NAME = 'email_value';

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
     * @return EmailValue
     */
    /**
     * @param                   $value
     * @param  AbstractPlatform $platform
     * @return EmailValue
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): EmailValue
    {
        return EmailValue::fromString($value);
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
