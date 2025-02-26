<?php

namespace App\UseCases\User;

class SubmitDayOffRequestUseCaseDto
{
    /**
     * @param  int  $userId
     * @param  string[]  $dayOffRequests
     */
    private function __construct(
        public readonly int $userId,
        public readonly array $dayOffRequests,
    ) {}

    /**
     * Summary of create
     * @param int $userId
     * @param string[] $dayOffRequests
     * @return SubmitDayOffRequestUseCaseDto
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
