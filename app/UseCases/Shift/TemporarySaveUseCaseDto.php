<?php

namespace app\UseCases\Shift;

use DateTimeImmutable;

class TemporarySaveUseCaseDto
{
    /**
     * @param  int[]  $dayShiftUserIds
     * @param  int[]  $lateShiftUserIds
     * @param  int[]  $nightShiftUserIds
     */
    private function __construct(
        public readonly DateTimeImmutable $date,
        public readonly array $dayShiftUserIds,
        public readonly array $lateShiftUserIds,
        public readonly array $nightShiftUserIds,
    ) {}

    /**
     * @param  int[]  $dayShiftUserIds
     * @param  int[]  $lateShiftUserIds
     * @param  int[]  $nightShiftUserIds
     */
    public static function create(
        DateTimeImmutable $date,
        array $dayShiftUserIds,
        array $lateShiftUserIds,
        array $nightShiftUserIds,
    ): self {
        return new self(
            $date,
            $dayShiftUserIds,
            $lateShiftUserIds,
            $nightShiftUserIds,
        );
    }
}
