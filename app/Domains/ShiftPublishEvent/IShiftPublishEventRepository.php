<?php

namespace app\Domains\ShiftPublishEvent;

interface IShiftPublishEventRepository
{
    public function create(ShiftPublishEvent $shiftPublishEvent): void;
}
