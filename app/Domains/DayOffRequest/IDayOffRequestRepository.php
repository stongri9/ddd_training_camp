<?php

namespace app\Domains\DayOffRequest;

use app\Models\DayOffRequest as DayOffRequestModel;
use Illuminate\Database\Eloquent\Collection;

interface IDayOffRequestRepository
{
    public function find(int $id): ?DayOffRequestModel;

    /**
     * @return Collection<int, DayOffRequestModel>
     */
    public function findByUserId(int $userId): Collection;

    public function create(DayOffRequest $dayOffRequest): int;
}
