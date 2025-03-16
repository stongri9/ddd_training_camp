<?php

namespace app\Domains\DayOffRequest;

use app\Domains\Shift\IShiftRepository;

class SubmitDayOffRequestSpecification
{
    public function __construct(
        private IShiftRepository $shiftRepository,
    ) {}

    /**
     * @param  DayOffRequestDateCollection  $dayOffRequestDateCollection
     */
    public function isSatisfied(DayOffRequestDateCollection $dayOffRequestDateCollection): bool
    {
        // 最新の確定したシフトよりも休みを希望する日付が後の場合はエラー
        $latestShift = $this->shiftRepository->getLatestShift();

        foreach ($dayOffRequestDateCollection->dayOffRequestDates as $dayOffRequestDate) {
            if (isset($latestShift) && $latestShift->date->format('y-m-d') > ($dayOffRequestDate->date->format('y-m-d'))) {
                return false;
            }
        }

        return true;
    }
}
