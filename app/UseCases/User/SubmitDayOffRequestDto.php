<?php

namespace App\UseCases\User;

class SubmitDayOffRequestCaseDto {

    /**
     * @param string $userId
     * @param string[] $dayOffRequests
     */
    private function __construct(
        public readonly int $userId,
        public readonly array $dayOffRequests,
    ){
    }

    /**
     * @param string $userId
     * @param string[] $dayOffRequests
     * @return \App\UseCases\User\SubmitDayOffRequestCaseDto
     */ 
    public static function create(
        string $userId,
        array $dayOffRequests,
    ): self {
        return new self(
            $userId,
            $dayOffRequests,
        );
    }
}