<?php

namespace app\Repositories\ShiftPublishEvent;

use app\Domains\ShiftPublishEvent\IShiftPublishEventRepository;
use app\Domains\ShiftPublishEvent\ShiftPublishEvent;
use app\Models\ShiftPublishEvent as ShiftPublishEventModel;

class ShiftPublishEventRepository implements IShiftPublishEventRepository
{
    public function create(ShiftPublishEvent $shiftPublishEvent): void
    {
        ShiftPublishEventModel::create([
            'start_date' => $shiftPublishEvent->start_date,
            'end_date' => $shiftPublishEvent->end_date,
        ]);
    }
}
