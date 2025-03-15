<?php

namespace app\UseCases\User;

use app\Domains\User\IUserRepository;
use app\Domains\User\SubmitDayOffRequestSpecification;
use InvalidArgumentException;

class SubmitDayOffRequestUseCase
{
    public function __construct(
        private readonly IUserRepository $userRepository,
        private readonly SubmitDayOffRequestSpecification $submitDayOffRequestSpecification
    ) {}

    public function __invoke(SubmitDayOffRequestUseCaseDto $dto): void
    {
        if (! $this->submitDayOffRequestSpecification->isSatisfied($dto->dayOffRequests)) {
            throw new InvalidArgumentException('申請できない日付が含まれています。');
        }

        $user = $this->userRepository->find($dto->userId);

        if (is_null($user)) {
            throw new \InvalidArgumentException('存在しないユーザーです。');
        }

        try {
            $user->updateDayOffRequests($dto->dayOffRequests);
            $this->userRepository->update($user);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
