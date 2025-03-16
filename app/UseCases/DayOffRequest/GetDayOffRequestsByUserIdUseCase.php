<?php

namespace app\UseCases\DayOffRequest;

use app\Domains\DayOffRequest\IDayOffRequestRepository;
use app\Domains\User\ExistUserSpecification;
use Illuminate\Database\Eloquent\Collection;
use app\Models\DayOffRequest as DayOffRequestModel;

class GetDayOffRequestsByUserIdUseCase
{
    public function __construct(
        private readonly IDayOffRequestRepository $dayOffRequestRepository,
        private readonly ExistUserSpecification $existUserSpecification,
    ) {
    }

    /**
     * @return Collection<int, DayOffRequestModel>
     */
    public function __invoke(int $userId): Collection
    {
        if (!$this->existUserSpecification->isSatisfied($userId)) {
            throw new \InvalidArgumentException('ユーザーが存在しません');
        }

        return $this->dayOffRequestRepository->findByUserId($userId);
    }
}