<?php

namespace app\UseCases\ShiftChangeApplicationResult;

class CreateUseCaseDto
{
    private function __construct(
        public readonly int $shift_change_application_id,
        public readonly int $confirm_user_id,
        public readonly string $result_type,
        public readonly string $comment,
    ) {}

    public static function create(
        int $shift_change_application_id,
        int $confirm_user_id,
        string $result_type,
        string $comment,
    ): self {
        return new CreateUseCaseDto(
            $shift_change_application_id,
            $confirm_user_id,
            $result_type,
            $comment,
        );
    }
}
