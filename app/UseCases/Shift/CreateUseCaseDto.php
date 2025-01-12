<?php

namespace App\UseCases\Shift;

class CreateUseCaseDto {
    private function __construct(
        public readonly string $startDate,
        public readonly string $endDate,
    ) {
    }

    public static function create(
        string $startDate,
        string $endDate,
    ): self
    {
        return new CreateUseCaseDto(
            $startDate,
            $endDate,
        );
    }
}