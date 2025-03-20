<?php

namespace app\Domains\ShiftChangeApplicationResult;

interface IShiftChangeApplicationResultRepository
{
    public function create(ShiftChangeApplicationResult $shift_change_application_result): void;
}
