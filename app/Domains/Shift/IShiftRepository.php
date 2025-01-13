<?php 

namespace App\Domains\Shift;

use Illuminate\Support\Collection;

interface IShiftRepository {
    public function getLatestShift(): Shift|null;
    public function create(Shift $shift): void;
    public function createAll(Collection $shiftCollecton): void;
    public function getShiftsByPeriod(\DateTimeInterface $startDate, \DateTimeInterface $endDate): Collection;
    public function getShiftByDate(\DateTimeInterface $date): Shift|null;
}