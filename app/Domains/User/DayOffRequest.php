<?php

namespace App\Domains\User;

use DateTimeImmutable;

class DayOffRequest
{
    /**
     * @param  string  $date
     */
    private function __construct(
        public DateTimeImmutable $date,
    ) {}

    /**
     * @return \App\Domains\DayOffRequest
     */
    public static function create(
        string $date
    ): self {
        return new self(new DateTimeImmutable($date));
    }

    /**
     * @return \App\Domains\DayOffRequest
     */
    public static function reconstruct(
        string $date
    ): self {
        return new self(new DateTimeImmutable($date));
    }
}
