<?php

namespace App\UseCases\User;

use App\Domains\User\User;
use App\Domains\User\IUserRepository;
use App\Domains\User\DayOffRequest;
use App\Domains\User\SubmitDayOffRequestSpecification;
use App\UseCases\User\SubmitDayOffRequestCaseDto;
use InvalidArgumentException;

class SubmitDayOffRequestUseCase {
    public function __construct(
        private readonly IUserRepository $userRepository,
        private readonly SubmitDayOffRequestSpecification $submitDayOffRequestSpecification
    ) {}

    public function __invoke(SubmitDayOffRequestCaseDto $dto): void
    {
        if (!$this->submitDayOffRequestSpecification->isSatisfied($dto->dayOffRequests)) {
            throw new InvalidArgumentException(PHP_EOL, '申請できない日付が含まれています');
        }

        $userModel = $this->userRepository->find($dto->userId);
        if (is_null($userModel)) {
            throw new InvalidArgumentException(PHP_EOL, 'ユーザーが見つかりません');
        }
        $user = User::reconstruct($userModel->id, $userModel->dayOffRequests);

        try {
            $user->update(array_map(fn ($dayOffRequest) => DayOffRequest::create($dayOffRequest), $dto->dayOffRequests));
            $this->userRepository->update($user);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
