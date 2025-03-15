<?php

namespace App\Domains\User;

use App\Domains\Shift\IShiftRepository;
use DateTimeImmutable;

class SubmitDayOffRequestSpecification
{
    public function __construct(
        private IShiftRepository $shiftRepository,
    ) {}

    /**
     * @param  string[]  $dayOffRequests
     */
    public function isSatisfied(array $dayOffRequests): bool
    {
        // 最新の確定したシフトよりも休みを希望する日付が後の場合はエラー
        $latestShift = $this->shiftRepository->getLatestShift();

        foreach ($dayOffRequests as $dayOffRequest) {
            if ($latestShift->date->format('y-m-d') > (new DateTimeImmutable($dayOffRequest))->format('y-m-d')) {
                return false;
            }
        }

        return true;
    }
}
