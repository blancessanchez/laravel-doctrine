<?php

namespace App\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Money\Currency;
use Money\Money;

class MoneyType extends Type
{
    const MONEY = 'Money';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'VARCHAR(255)';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $decodedValue = json_decode($value, true);

        return new Money($decodedValue['amount'], new Currency($decodedValue['currency']));
    }

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

    public function getName()
    {
        return self::MONEY;
    }
}