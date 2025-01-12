<?php

namespace App\Dommains\DayOffRequest;

use App\Domains\Shared\Date;

class DayOffRequest
{
    /**
     * @param string $date
     * @throws \InvalidArgumentException
     */
    public function __construct(
        public readonly string $date,
    ) {
        if (!is_a($date, Date::class)) {
            throw new \InvalidArgumentException(
                    '日付の形式が不正です。'
            );
        }
    }

    /**
     * @param string $date
     * @throws \InvalidArgumentException
     */
    public function reconstruct(
        string $date
    ) {
        return new self($date);
    }
}