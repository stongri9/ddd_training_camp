<?php 

namespace App\Domains\Shift;

interface IShiftRepository {
    public function getLatestShift(): Shift;
}