<?php

namespace App\Domains\User;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\DayOffRequestFactory;

class DayOffRequest
{
    use HasFactory;

    /**
     * @param string $date
     */
    private function __construct(
        public DateTimeImmutable $date,
    ) {
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

    protected static function newFactory()
    {
        return DayOffRequestFactory::new();
    }
}
