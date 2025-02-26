<?php

namespace App\Domains\User;

use DateTimeImmutable;

class DayOffRequest
{
    private function __construct(public DateTimeImmutable $date) {}

    public static function create(string $date): self
    {
        return new self(new DateTimeImmutable($date));
    }

    public static function reconstruct(string $date): self
    {
        return new self(new DateTimeImmutable($date));
    }
}
