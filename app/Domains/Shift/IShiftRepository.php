<?php

namespace app\Domains\Shift;

use Illuminate\Support\Collection;

interface IShiftRepository
{
    public function getLatestShift(): ?Shift;

    public function create(Shift $shift): void;

    /**
     * @param Collection<int, Shift> $shiftCollecton
     * @return void
     */
    public function insert(Collection $shiftCollecton): void;

    /**
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $endDate
     * @return Collection<int, Shift>
     */
    public function getShiftsByPeriod(\DateTimeInterface $startDate, \DateTimeInterface $endDate): Collection;

    public function getShiftByDate(\DateTimeInterface $date): ?Shift;
}
