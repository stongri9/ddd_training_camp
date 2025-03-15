<?php

namespace app\Domains\User;

use Database\Factories\DayOffRequestFactory;
use DateTimeImmutable;

class DayOffRequest
{
    /**
     * @param  int|null  $id
     * @param  int|null  $user_id
     * @param  DateTimeImmutable  $date
     */
    private function __construct(
        public readonly ?int $id,
        public readonly ?int $user_id,
        public private(set) DateTimeImmutable $date
    ) {}

    public static function create(
        ?int $user_id,
        string $date
    ): self {
        return new self(
            null,
            $user_id,
            new DateTimeImmutable($date)
        );
    }

    public static function reconstruct(
        int $id,
        int $user_id,
        string $date
    ): self {
        return new self(
            $id,
            $user_id,
            new DateTimeImmutable($date)
        );
    }

    /**
     * @return \Database\Factories\DayOffRequestFactory
     */
    protected static function newFactory()
    {
        return DayOffRequestFactory::new();
    }
}
