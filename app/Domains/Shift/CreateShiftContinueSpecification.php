<?php

namespace app\Domains\Shift;

use Illuminate\Support\Collection;

class CreateShiftContinueSpecification
{
    /**
     * @param  Collection<int, Shift>  $shiftCollection
     * @param  Collection<int, Shift>  $before6dayShifts
     * @param  Collection<int, Shift>  $after6dayShifts
     * @return string[]
     */
    public function getViolations(
        Collection $shiftCollection,
        Collection $before6dayShifts,
        Collection $after6dayShifts,
    ): array {
        $violations = [];

        // ７連勤以上できない
        $mergedShifts = $shiftCollection->merge([...$before6dayShifts, ...$after6dayShifts])->sortBy('date');
        $userShiftMappings = [];
        foreach ($mergedShifts as $shift) {
            $date = $shift->date;
            foreach ($shift->userIds as $userId) {
                if (! isset($userShiftMappings[$userId])) {
                    $userShiftMappings[$userId] = [];
                }
                $userShiftMappings[$userId][] = $date;
            }
        }

        foreach ($userShiftMappings as $dates) {
            $consecutiveWorkingDays = 0;
            $maxConsecutiveWorkingDays = 0;
            $dayBefore = null;
            foreach ($dates as $date) {
                if (isset($dayBefore) && $date->format('Y-m-d') === $dayBefore->modify('+1 day')->format('Y-m-d')) {
                    $consecutiveWorkingDays++;
                } else {
                    $consecutiveWorkingDays = 1;
                }
                $maxConsecutiveWorkingDays = max($maxConsecutiveWorkingDays, $consecutiveWorkingDays);
                $dayBefore = $date;
            }
            if ($maxConsecutiveWorkingDays >= 7) {
                $violations[] = '7日以上の連勤はできません。';
                break;
            }
        }

        // 直前の夜勤シフトと重複しない
        $shiftBeforeMinDate = $before6dayShifts->sortBy('date')->first();
        /** @var \DateTimeImmutable */
        $maxDate = $shiftCollection->max('date');

        if (isset($shiftBeforeMinDate)) {
            $shiftCollection->merge($shiftBeforeMinDate)->sortBy('date');
        }

        foreach ($shiftCollection as $shift) {
            $nextDayShift = $shift->date === $maxDate
                ? $after6dayShifts->sortByDesc('date')->first()
                : $shiftCollection->where('date', $shift->date->modify('+1 day'))->first();

            if (isset($nextDayShift) && ! empty(array_intersect($nextDayShift->userIds, $shift->nightShiftUserIds))) {
                $violations[] = '夜勤の人は翌日は休みである必要があります。';
            }
        }

        return $violations;
    }
}
