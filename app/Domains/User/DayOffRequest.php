<?php

namespace app\Domains\User;

use DateTimeImmutable;

class DayOffRequest
{
    private function __construct(
        public readonly DateTimeImmutable $date,
        public readonly ?int $id = null
    ) {}

    public static function create(
        string $date
    ): self {
        return new self(
            date: new DateTimeImmutable($date)
        );
    }

    public static function reconstruct(
        int $id,
        string $date
    ): self {
        return new self(
            date: new DateTimeImmutable($date),
            id: $id,
        );
    }
}
