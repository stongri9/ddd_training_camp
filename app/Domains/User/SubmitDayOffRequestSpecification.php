<?php

namespace App\Domains\User;

use App\Domains\Shared\dayOffRequests;
use App\Domains\Shift\IShiftRepository;
use DateTimeImmutable;

class SubmitDayOffRequestSpecification
{
    public function __construct(
        private IShiftRepository $shiftRepository,
    ) {
    }

    /**
    * @param string[] $dayOffRequests
    * @return string[]
    */
    public function getViolations(array $dayOffRequests): array
    {
        $violations = [];

        // 最新の確定したシフトよりも休みを希望する日付が後の場合はエラー
        $latestShift = $this->shiftRepository->getLatestShift();
        foreach ($dayOffRequests as $dayOffRequest) {
            if ($latestShift->date->format("y-m-d") > (new DateTimeImmutable($dayOffRequest))->format("y-m-d")) {
                $violations[] = "最新の確定したシフト（{$latestShift->date->format("y-m-d")}）よりも日付が後の休みを申請することはできません";
                break;
            }
        }

        return $violations;
    }
}