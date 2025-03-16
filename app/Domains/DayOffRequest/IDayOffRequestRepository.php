<?php

namespace app\Domains\DayOffRequest;

use app\Models\DayOffRequest as DayOffRequestModel;

interface IDayOffRequestRepository
{
    public function find(int $id): ?DayOffRequestModel;

    public function create(DayOffRequest $dayOffRequest): int;
}
