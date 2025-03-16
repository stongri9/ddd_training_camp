<?php

namespace app\UseCases\Shift;

class ShowUseCaseDto
{
    private function __construct(
        public readonly string $start_date,
        public readonly string $end_date,
        public readonly bool $is_published_edit,
    ) {}

    public static function create(
        string $start_date,
        string $end_date,
        bool $is_published_edit,
    ): self {
        return new ShowUseCaseDto(
            $start_date,
            $end_date,
            $is_published_edit,
        );
    }
}
