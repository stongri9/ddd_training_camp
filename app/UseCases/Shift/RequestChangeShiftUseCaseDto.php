<?php

namespace app\UseCases\Shift;

use app\Domains\Shift\Shift;
use DateTimeImmutable;

class RequestChangeShiftUseCaseDto
{
    private function __construct(
        public readonly Shift $shift,
        public readonly DateTimeImmutable $date,
        /** @var int[] */
        public readonly array $requestDayShiftUserIds,
        /** @var int[] */
        public readonly array $requestLateShiftUserIds,
        /** @var int[] */
        public readonly array $requestNightShiftUserIds,
        public readonly int $userId,
        public readonly string $comment
    ) {}

    /**
     * @param  int[]  $requestDayShiftUserIds
     * @param  int[]  $requestLateShiftUserIds
     * @param  int[]  $requestNightShiftUserIds
     */
    public static function create(
        Shift $shift,
        DateTimeImmutable $date,
        array $requestDayShiftUserIds,
        array $requestLateShiftUserIds,
        array $requestNightShiftUserIds,
        int $userId,
        string $comment
    ): self {
        return new RequestChangeShiftUseCaseDto(
            $shift,
            $date,
            $requestDayShiftUserIds,
            $requestLateShiftUserIds,
            $requestNightShiftUserIds,
            $userId,
            $comment
        );
    }
}
