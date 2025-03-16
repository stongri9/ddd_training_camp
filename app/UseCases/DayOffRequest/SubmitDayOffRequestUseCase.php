<?php

namespace app\UseCases\DayOffRequest;

use app\Domains\DayOffRequest\DayOffRequest;
use app\Domains\User\IUserRepository;
use app\Domains\DayOffRequest\SubmitDayOffRequestSpecification;
use app\Domains\DayOffRequest\IDayOffRequestRepository;

class SubmitDayOffRequestUseCase
{
    public function __construct(
        private readonly IDayOffRequestRepository $dayOffRequestRepository,
        private readonly IUserRepository $userRepository,
        private readonly SubmitDayOffRequestSpecification $submitDayOffRequestSpecification
    ) {}

    public function __invoke(SubmitDayOffRequestUseCaseDto $dto): int
    {
        if (! $this->submitDayOffRequestSpecification->isSatisfied($dto->day_off_request_days)) {
            throw new \InvalidArgumentException('申請できない日付が含まれています。');
        }

        $user = $this->userRepository->find($dto->user_id);

        if (is_null($user)) {
            throw new \InvalidArgumentException('存在しないユーザーです。');
        }

        $dayOffRequest = DayOffRequest::create(
            $dto->day_off_request_days,
            $dto->user_id,
        );

        try {
            return $this->dayOffRequestRepository->create($dayOffRequest);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
