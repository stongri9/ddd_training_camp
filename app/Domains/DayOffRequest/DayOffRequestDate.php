<?php

namespace app\Domains\DayOffRequest;

use DateTimeImmutable;

class DayOffRequestDate
{
    /**
     * @param  DateTimeImmutable  $date
     */
    private function __construct(
        public readonly DateTimeImmutable $date
    ) {}

    public static function create(DateTimeImmutable $date): self
    {
        if ($date < new DateTimeImmutable('today')) {
            throw new \Exception('不正な休み希望日です。');
        }
        return new self($date);
    }
}
