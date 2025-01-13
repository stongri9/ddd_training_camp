<?php
namespace App\Domains\Shift;

use Illuminate\Support\Collection;

class CreateShiftContinueSpecification {
    public function __construct(
        private readonly IShiftRepository $shiftRepository,
    ) {
    }

    /**
     * @param Collection<Shift> $shiftCollection
     * @return string[]
     */
    public function getViolations(
        Collection $shiftCollection
    ): array  {
        $violations = [];
        //７連勤以上できない
        $maxDate = $shiftCollection->max('date');
        $minDate = $shiftCollection->min('date');
        $before6dayshifts = $this->shiftRepository->getShiftsByPeriod($minDate->modify('-7 day'), $minDate->modify('-1 day'));
        $after6dayshifts = $this->shiftRepository->getShiftsByPeriod($maxDate->modify('+1 day'), $maxDate->modify('+7 day'));
        $mergedShifts =$shiftCollection->add($before6dayshifts)->add($after6dayshifts)->sortByAsc('date');
        $userShiftMappings = [];
        foreach ($mergedShifts as $shift) {
            $date = $shift->date;
            foreach ($shift->userIds as $userId) {
                if (!isset($userShiftMappings[$userId])) {
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

        $shiftCollection->add($this->shiftRepository->getShiftByDate($maxDate->modify('-1 day')));
        foreach($shiftCollection as $shift){
            if ($shift->date === $maxDate) {
                $nextDayShift = $this->shiftRepository->getShiftByDate($maxDate->modify('+1 day'));
            } else {
                $nextDayShift = $shiftCollection->where('date', $shift->date->modify('+1 day'));
            }         
            if (!empty(array_intersect($nextDayShift->UserIds, $shift->nightShiftUserIds))){
                $violations[] = '夜勤の人は翌日は休みである必要があります。';
            };
        }

        return $violations;
    }
}