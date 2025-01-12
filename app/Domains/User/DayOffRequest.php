<?php

namespace App\Dommains\DayOffRequest;

use App\Domains\Shared\Date;

class DayOffRequest
{
    /**
     * @param string $date
     */
    private function __construct(
        public readonly string $date,
    ) {
    }

    /**
     * @param string $date
     * @return \App\Domains\DayOffRequest
     */
    public static function create(
        string $date
    ): self {
        $this->validate($date);
        return new self($date);
    }

    /**
     * @param string $date
     * @return \App\Domains\DayOffRequest
     */
    public static function reconstruct(
        string $date
    ): self {
        return new self($date);
    }

    /**
     * @return void
     * @throws \InvalidArgumentException
     */
    public function validate(string $date): void
    {
        if (!is_a($date, Date::class)) {
            throw new \InvalidArgumentException(
                    '日付の形式が不正です。'
            );
        }
    }
}