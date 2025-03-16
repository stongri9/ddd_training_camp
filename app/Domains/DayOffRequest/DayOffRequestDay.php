<?php

namespace app\Domains\DayOffRequest;

use DateTimeImmutable;

class DayOffRequestDay
{
    private function __construct(
        public readonly DateTimeImmutable $value,
    ) {
    }

    public static function create(
        string $date
    ): self {
        return new self(new DateTimeImmutable($date));
    }
}
