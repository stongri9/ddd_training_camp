<?php

namespace app\UseCases\Shift;

class ShowUseCaseDto
{
    private function __construct(
        public readonly int $year,
        public readonly int $month
    ) {}

    public static function create(
        int $year,
        int $month
    ): self {
        return new ShowUseCaseDto(
            $year,
            $month
        );
    }
}
