<?php

namespace app\UseCases\User;

class SubmitDayOffRequestUseCaseDto
{
    /**
     * @param  string[]  $day_off_requests
     */
    private function __construct(
        public readonly int $user_id,
        public readonly array $day_off_requests,
    ) {}

    /**
     * Summary of create
     *
     * @param  string[]  $day_off_requests
     */
    public static function create(
        int $user_id,
        array $day_off_requests,
    ): self {
        return new self(
            $user_id,
            $day_off_requests,
        );
    }
}
