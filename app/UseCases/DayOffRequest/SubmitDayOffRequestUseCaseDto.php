<?php

namespace app\UseCases\DayOffRequest;

class SubmitDayOffRequestUseCaseDto
{
    /**
     * @param  string[]  $day_off_request_days
     */
    private function __construct(
        public readonly int $user_id,
        public readonly array $day_off_request_days,
    ) {}

    /**
     * Summary of create
     *
     * @param  string[]  $day_off_requests
     */
    public static function create(
        int $user_id,
        array $day_off_request_days,
    ): self {
        return new self(
            $user_id,
            $day_off_request_days,
        );
    }
}
