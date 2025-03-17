<?php

namespace app\UseCases\ShiftPublishEvent;

class PublishUseCaseDto
{
    /**
     * @param  array{id: int, date: string, dayShiftUserIds: int[], lateShiftUserIds: int[], nightShiftUserIds: int[]}[]  $shifts
     */
    private function __construct(
        public readonly array $shifts,
    ) {}

    /**
     * @param  array{id: int, date: string, dayShiftUserIds: int[], lateShiftUserIds: int[], nightShiftUserIds: int[]}[]  $shifts
     */
    public static function create(
        array $shifts,
    ): self {
        if (empty($shifts)) {
            throw new \InvalidArgumentException('公開するシフトがありません');
        }

        return new self($shifts);
    }
}
