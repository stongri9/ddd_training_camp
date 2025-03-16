<?php

namespace app\Repositories\DayOffRequest;

use app\Domains\DayOffRequest\DayOffRequest;
use app\Domains\DayOffRequest\IDayOffRequestRepository;
use app\Models\DayOffRequest as DayOffRequestModel;
use app\Models\DayOffRequestDay as DayOffRequestDayModel;
use Illuminate\Database\Eloquent\Collection;

class DayOffRequestRepository implements IDayOffRequestRepository
{
    public function find(int $id): ?DayOffRequestModel
    {
        return DayOffRequestModel::find($id);
    }

    /**
     * @return Collection<int, DayOffRequestModel>
     */
    public function findByUserId(int $userId): Collection
    {
        return DayOffRequestModel::where('user_id', $userId)->get();
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
