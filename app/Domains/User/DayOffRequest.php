<?php

namespace App\Domains\User;

use DateTimeImmutable;

class DayOffRequest
{
    /**
     * @param string $date
     */
    private function __construct(
        public string $date,
    ) {
    }

    /**
     * @param string $date
     * @return \App\Domains\DayOffRequest
     */
    public static function create(
        string $date
    ): self {
        $dateObject = new DateTimeImmutable($date);
        return new self($dateObject->format('Y-m-d'));
    }

    /**
     * @param string $date
     * @return \App\Domains\DayOffRequest
     */
    public static function reconstruct(
        string $date
    ): self {
        $dateObject = new DateTimeImmutable($date);
        return new self($dateObject->format('Y-m-d'));
    }
}
