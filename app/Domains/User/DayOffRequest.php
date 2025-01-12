<?php

namespace App\Dommains\DayOffRequest;

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
        return new self(new Date($date));
    }

    /**
     * @param string $date
     * @return \App\Domains\DayOffRequest
     */
    public static function reconstruct(
        string $date
    ): self {
        return new self(new Date($date));
    }
}