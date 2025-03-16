<?php

namespace app\Repositories\DayOffRequest;

use app\Domains\DayOffRequest\DayOffRequest;
use app\Domains\DayOffRequest\IDayOffRequestRepository;
use app\Models\DayOffRequest as DayOffRequestModel;
use app\Models\DayOffRequestDay as DayOffRequestDayModel;

class DayOffRequestRepository implements IDayOffRequestRepository
{
    public function find(int $id): ?DayOffRequestModel
    {
        return DayOffRequestModel::find($id);
    }

    public function create(DayOffRequest $dayOffRequest): int
    {
        $dayOffRequestModel = DayOffRequestModel::create([
            'user_id' => $dayOffRequest->user_id,
        ]);

        foreach ($dayOffRequest->day_off_request_days as $dayOffRequestDay) {
            DayOffRequestDayModel::create([
                'day_off_request_id' => $dayOffRequestModel->id,
                'date' => $dayOffRequestDay->value->format('Y-m-d'),
            ]);
        }

        return $dayOffRequestModel->id;
    }
}
