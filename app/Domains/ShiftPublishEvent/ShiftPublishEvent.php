<?php

namespace app\Domains\ShiftPublishEvent;

use DateTimeImmutable;

class ShiftPublishEvent
{
    private function __construct(
        public readonly DateTimeImmutable $start_date,
        public readonly DateTimeImmutable $end_date,
    ) {}

    public static function create(DateTimeImmutable $start_date, DateTimeImmutable $end_date): self
    {
        if ($start_date > $end_date) {
            throw new \InvalidArgumentException('開始日は終了日よりも前の日付である必要があります');
        }

        return new self($start_date, $end_date);
    }
}
