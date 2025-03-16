<?php

namespace app\Domains\Shift;

class ShiftChangeOriginAssignment
{
    /**
     * @param  int[]  $dayShiftUserIds
     * @param  int[]  $lateShiftUserIds
     * @param  int[]  $nightShiftUserIds
     */
    private function __construct(
        public private(set) array $dayShiftUserIds,
        public private(set) array $lateShiftUserIds,
        public private(set) array $nightShiftUserIds,
    ) {}

    /**
     * @return ShiftChangeOriginAssignment
     */
    public static function createFromShift(Shift $shift)
    {
        $shiftEntity = new ShiftChangeOriginAssignment(
            $shift->dayShiftUserIds,
            $shift->lateShiftUserIds,
            $shift->nightShiftUserIds
        );

        return $shiftEntity;
    }
}
