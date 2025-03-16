<?php

namespace app\Domains\Shift;

use DateTimeImmutable;

class ShiftChangeApplication
{
    /**
     * @param  \DateTimeImmutable  $date
     * @param  ShiftChangeOriginAssignment  $shiftChangeOriginAssignment
     * @param  ShiftChangeRequestAssignment  $shiftChangeRequestAssignment
     * @param  int  $userId
     * @param  string  $comment
     */
    private function __construct(
        public readonly ?int $id,
        public private(set) DateTimeImmutable $date,
        public private(set) ShiftChangeOriginAssignment $shiftChangeOriginAssignment,
        public private(set) ShiftChangeRequestAssignment $shiftChangeRequestAssignment,
        public private(set) int $userId,
        public private(set) string $comment
    ) {}

    /**
     * @param  Shift  $shift
     * @param  DateTimeImmutable  $date
     * @param  int[]  $requestDayShiftUserIds
     * @param  int[]  $requestLateShiftUserIds
     * @param  int[]  $requestNightShiftUserIds
     * @param  int  $userId
     * @param  string  $comment
     * @return ShiftChangeApplication
     */
    public static function create(Shift $shift, DateTimeImmutable $date, array $requestDayShiftUserIds, array $requestLateShiftUserIds, array $requestNightShiftUserIds, int $userId, string $comment)
    {
        $shiftChangeOriginAssignment = $shift->convertShiftChangeOriginAssignment();
        $shiftChangeRequestAssignment = ShiftChangeRequestAssignment::create($date, $requestDayShiftUserIds, $requestLateShiftUserIds, $requestNightShiftUserIds);
        $shiftChangeApplicationEntity = new ShiftChangeApplication(
            null,
            $date,
            $shiftChangeOriginAssignment,
            $shiftChangeRequestAssignment,
            $userId,
            $comment
        );

        return $shiftChangeApplicationEntity;
    }
}
