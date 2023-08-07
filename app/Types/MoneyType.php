<?php

namespace App\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Money\Currency;
use Money\Money;

class MoneyType extends Type
{
    /**
     * @var string
     */
    const MONEY = 'Money';

    /**
     * getSQLDeclaration
     *
     * @param  array $fieldDeclaration
     * @param  AbstractPlatform $platform
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'VARCHAR(255)';
    }

    /**
     * convertToPHPValue
     *
     * @param  mixed $value
     * @param  AbstractPlatform $platform
     * @return Money|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $decodedValue = json_decode($value, true);

        return new Money($decodedValue['amount'], new Currency($decodedValue['currency']));
    }

    /**
     * convertToDatabaseValue
     *
     * @param  mixed $value
     * @param  AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return json_encode([
            'amount' => $value->getAmount(),
            'currency' => $value->getCurrency()->getCode(),
        ]);
    }
    
    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return self::MONEY;
    }
}