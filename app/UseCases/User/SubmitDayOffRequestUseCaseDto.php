<?php

namespace App\UseCases\User;

class SubmitDayOffRequestUseCaseDto
{
    /**
     * @param  string[]  $dayOffRequests
     */
    private function __construct(
        public readonly int $userId,
        public readonly array $dayOffRequests,
    ) {}

    /**
     * Summary of create
     *
     * @param  string[]  $dayOffRequests
     */
    public static function create(
        int $userId,
        array $dayOffRequests,
    ): self {
        return new self(
            $userId,
            $dayOffRequests,
        );
    }
}
