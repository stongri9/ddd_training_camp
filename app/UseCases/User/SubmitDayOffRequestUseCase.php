<?php

namespace App\UseCases\User;

use App\Domains\User\User;
use App\Domains\User\IUserRepository;
use App\Domains\User\DayOffRequest;
use App\Domains\User\SubmitDayOffRequestSpecification;
use App\UseCases\User\SubmitDayOffRequestCaseDto;
use DateTimeImmutable;
use InvalidArgumentException;

class SubmitDayOffRequestUseCase {
    public function __construct(
        private readonly IUserRepository $userRepository,
        private readonly SubmitDayOffRequestSpecification $submitDayOffRequestSpecification
    ) {}

    public function __invoke(SubmitDayOffRequestCaseDto $dto): void
    {
        try {
            $errors = $this->submitDayOffRequestSpecification->getViolations($dto->dayOffRequests);

            if (filled($errors)) {
                throw new InvalidArgumentException(implode(PHP_EOL, $errors));
            }

            $userModel = $this->userRepository->find($dto->userId);
            $user = User::reconstruct($userModel->id, $userModel->dayOffRequests);

            $user->update(array_map(function($dayOffRequest) {
                return DayOffRequest::create($dayOffRequest);
            }, $dto->dayOffRequests));
            
            $this->userRepository->update($user);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}