<?php

namespace app\Domains\Shift;

interface IShiftChangeApplicationRepository
{
    public function create(ShiftChangeApplication $shiftChangeApplication): void;
}
