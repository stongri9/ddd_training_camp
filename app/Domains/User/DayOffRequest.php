<?php

namespace App\Domains\User;

use Database\Factories\DayOffRequestFactory;
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

    /**
     * @return \Database\Factories\DayOffRequestFactory
     */
    protected static function newFactory()
    {
        return DayOffRequestFactory::new();
    }
}
