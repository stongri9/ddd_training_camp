<?php

namespace App\UseCases\Shift;

class CreateUseCaseDto {
    private function __construct(
        public readonly string $date,
        public readonly array $dayShiftUserIds,
        public readonly array $lateShiftUserIds,
        public readonly array $nightShiftUserIds,
    ) {
    }

    public static function create(
        string $date,
        array $dayShiftUserIds,
        array $lateShiftUserIds,
        array $nightShiftUserIds,
    ): self
    {
        return new CreateUseCaseDto(
            $date,
            $dayShiftUserIds,
            $lateShiftUserIds,
            $nightShiftUserIds,
        );
    }
}