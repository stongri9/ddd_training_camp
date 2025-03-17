<?php

namespace app\UseCases\ShiftPublishEvent;

use DateTimeImmutable;

class CreateUseCaseDto
{
    private function __construct(
        public readonly DateTimeImmutable $start_date,
        public readonly DateTimeImmutable $end_date,
    ) {}

    public static function create(
        DateTimeImmutable $start_date,
        DateTimeImmutable $end_date,
    ): self {
        return new self($start_date, $end_date);
    }
}
