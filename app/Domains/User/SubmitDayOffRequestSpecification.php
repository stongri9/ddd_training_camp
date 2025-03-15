<?php

namespace app\Domains\User;

use app\Domains\Shift\IShiftRepository;
use DateTimeImmutable;

class SubmitDayOffRequestSpecification
{
    public function __construct(
        private IShiftRepository $shiftRepository,
    ) {}

    /**
     * @param  string[]  $day_off_requests
     */
    public function isSatisfied(array $day_off_requests): bool
    {
        // 最新の確定したシフトよりも休みを希望する日付が後の場合はエラー
        $latest_shift = $this->shiftRepository->getLatestShift();
        if (is_null($latest_shift)) {
            return true;
        }

        foreach ($day_off_requests as $day_off_request) {
            if ($latest_shift->date->format('y-m-d') > (new DateTimeImmutable($day_off_request))->format('y-m-d')) {
                return false;
            }
        }

        return true;
    }
}
