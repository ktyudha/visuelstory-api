<?php

namespace App\Enums\TicketCategory;

enum TicketCategoryEnum
{
    const INCREASE = 'increase';
    const DECREASE = 'decrease';

    public static function getAllValues(): array
    {
        return [
            self::INCREASE,
            self::DECREASE,
        ];
    }
}
