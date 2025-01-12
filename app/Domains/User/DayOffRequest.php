<?php

namespace App\Domains\User;

use DateTimeImmutable;

class DayOffRequest
{
    /**
     * @param DateTimeImmutable $date
     */
    private function __construct(
        public DateTimeImmutable $date,
    ) {
        $this->date = $date->format('Y-m-d');
    }

    /**
     * @param string $date
     * @return \App\Domains\DayOffRequest
     */
    public static function create(
        string $date
    ): self {
        return new self(new DateTimeImmutable($date));
    }

    /**
     * @param string $date
     * @return \App\Domains\DayOffRequest
     */
    public static function reconstruct(
        string $date
    ): self {
        return new self(new DateTimeImmutable($date));
    }
}