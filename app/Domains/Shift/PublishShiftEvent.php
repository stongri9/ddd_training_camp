<?php

namespace App\Domains\Shift;

use DateTimeImmutable;

class PublishShiftEvent
{
    /**
     * @param  int  $shiftId
     * @param  DateTimeImmutable  $date
     */
    private function __construct(
        public readonly ?int $id,
        public private(set) int $shiftId,
        public private(set) DateTimeImmutable $date,
        public private(set) int $createdUserId
    ) {}

    public static function create(
        int $shiftId,
        string $date,
        int $createdUserId
    ): self {
        return new self(
            null,
            $shiftId,
            new DateTimeImmutable($date),
            $createdUserId
        );
    }

    /**
     * @return App\Domains\Shift\PublishShiftEvent
     */
    public static function reconstruct(
        int $id,
        int $shiftId,
        string $date,
        int $createdUserId
    ): self {
        return new self(
            $id,
            $shiftId,
            new DateTimeImmutable($date),
            $createdUserId
        );
    }
}
