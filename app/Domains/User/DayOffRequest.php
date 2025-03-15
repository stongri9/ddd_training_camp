<?php

namespace app\Domains\User;

use DateTimeImmutable;

class DayOffRequest
{
    /**
     * @param  DateTimeImmutable  $date
     */
    private function __construct(
        public readonly ?int $id,
        public readonly DateTimeImmutable $date
    ) {}

    public static function create(
        string $date
    ): self {
        return new self(
            null,
            new DateTimeImmutable($date)
        );
    }

    public static function reconstruct(
        int $id,
        string $date
    ): self {
        return new self(
            $id,
            new DateTimeImmutable($date)
        );
    }
}
