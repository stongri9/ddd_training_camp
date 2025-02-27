<?php

namespace App\Domains\Shift;

use DateTimeImmutable;

class Shift
{
    /**
     * @param  \DateTimeImmutable  $date
     * @param  int[]  $dayShiftUserIds
     * @param  int[]  $lateShiftUserIds
     * @param  int[]  $nightShiftUserIds
     */
    private function __construct(
        public readonly ?int $id,
        public private(set) DateTimeImmutable $date,
        public private(set) array $dayShiftUserIds,
        public private(set) array $lateShiftUserIds,
        public private(set) array $nightShiftUserIds,
    ) {}

    /**
     * @param  int[]  $dayShiftUserIds
     * @param  int[]  $lateShiftUserIds
     * @param  int[]  $nightShiftUserIds
     * @return Shift
     *
     * @throws \InvalidArgumentException
     */
    public static function create(string $date, array $dayShiftUserIds, array $lateShiftUserIds, array $nightShiftUserIds)
    {
        if (count($nightShiftUserIds) < 2) {
            throw new \InvalidArgumentException('夜勤の人は2人以上必要です。');
        }

        $dateTimeObject = new DateTimeImmutable($date);
        $shiftEntity = new Shift(
            null,
            $dateTimeObject,
            $dayShiftUserIds,
            $lateShiftUserIds,
            $nightShiftUserIds
        );

        // TODO: 静的解析のためやむなく変数切り出し、マスタ化する際に消す
        /** @var string[] */
        $closedWeekDays = config('closedDays.closedWeekDays');
        /** @var string[] */
        $holidays = config('closedDays.holidays');
        $isBusinessDay = ! in_array($dateTimeObject->format('D'), $closedWeekDays)
                      && ! in_array($dateTimeObject->format('Y-m-d'), $holidays);
        if (! $isBusinessDay && count($dayShiftUserIds) < 3) {
            throw new \InvalidArgumentException('休院日の場合、日勤の人は3人以上必要です。');
        }
        if ($isBusinessDay && count($dayShiftUserIds) < 4) {
            throw new \InvalidArgumentException('営業日の場合、日勤の人は4人以上必要です。');
        }
        if ($isBusinessDay && count($lateShiftUserIds) < 1) {
            throw new \InvalidArgumentException('営業日の場合、遅番の人は1人以上必要です。');
        }

        return $shiftEntity;
    }
}
