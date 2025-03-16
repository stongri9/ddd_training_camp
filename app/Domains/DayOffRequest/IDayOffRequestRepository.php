<?php

namespace app\Domains\DayOffRequest;

use app\Models\DayOffRequest as DayOffRequestModel;
use Illuminate\Database\Eloquent\Collection;

interface IDayOffRequestRepository
{
    /**
     * @return Collection<int, DayOffRequestModel>
     */
    public function findByUserId(int $userId): Collection;

    /**
     * @param  DayOffRequest  $dayOffRequest
     */
    public function update(DayOffRequest $dayOffRequest): void;
}
