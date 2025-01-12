<?php 

namespace App\Domains\Shift;

use Illuminate\Support\Collection;

interface IShiftRepository {
    public function getLatestShift(): Shift;
    public function create(Shift $shift): void;
    public function getShiftsByPeriod(\DateTimeInterface $startDate, \DateTimeInterface $endDate): Collection;
    public function getShiftByDate(\DateTimeInterface $date): Shift;
}