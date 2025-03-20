<?php

namespace app\Domains\Shift;

use app\Models\Shift as ShiftModel;
use Illuminate\Support\Collection;

interface IShiftRepository
{
    public function getLatestShift(): ?ShiftModel;

    /**
     * @param  Collection<int, Shift>  $shiftCollection
     */
    public function insert(Collection $shiftCollection): void;

    /**
     * @return Collection<int, Shift>
     */
    public function getShiftsByPeriod(\DateTimeInterface $startDate, \DateTimeInterface $endDate): Collection;

    public function getShiftByDate(\DateTimeInterface $date): ?Shift;
}
