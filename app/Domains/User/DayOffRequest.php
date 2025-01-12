<?php

namespace App\Domains\User;

use App\Domains\Shared\Date;

class DayOffRequest
{
    /**
     * @param Date $date
     */
    private function __construct(
        public readonly Date $date,
    ) {
    }

    /**
     * @param string $date
     * @return \App\Domains\DayOffRequest
     */
    public static function create(
        string $date
    ): self {
        return new self(Date::create($date));
    }

    /**
     * @param string $date
     * @return \App\Domains\DayOffRequest
     */
    public static function reconstruct(
        string $date
    ): self {
        return new self(Date::create($date));
    }
}