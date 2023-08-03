<?php

namespace App\Enums;

enum StudentType: int
{
    case Regular = 1;
    case Irregular = 2;

    /**
     * Get the text representation of the enum
     *
     * @return string
     */
    public function text(): string
    {
        return match ($this) {
            self::Regular => 'Regular',
            self::Irregular => 'Irregular',
        };
    }

    /**
     * Get the list of values
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}