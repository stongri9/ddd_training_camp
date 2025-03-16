<?php

namespace app\Domains\DayOffRequest;

use app\Domains\Shift\IShiftRepository;
use DateTimeImmutable;

class SubmitDayOffRequestSpecification
{
    public function __construct(
        private IShiftRepository $shiftRepository,
    ) {}

    /**
     * @param  string[]  $day_off_request_days
     */
    public function isSatisfied(array $day_off_request_days): bool
    {
        $latest_shift = $this->shiftRepository->getLatestShift();

        // まだ一つもシフトが作成されていなかった場合はOK
        if (is_null($latest_shift)) {
            return true;
        }

        foreach ($day_off_request_days as $day_off_request_day) {
            $latestShiftDate = new DateTimeImmutable($latest_shift->date);
            if ($latestShiftDate->format('y-m-d') > (new DateTimeImmutable($day_off_request_day))->format('y-m-d')) {
                return false;
            }
        }

        return true;
    }
}
