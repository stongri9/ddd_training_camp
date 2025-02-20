<?php
namespace App\Domains\Shift;

use App\Attributes\Getter;
use DateTimeImmutable;

use App\Domains\DomainEntity;

class Shift extends DomainEntity {
    /**
     * @param int|null  $id
     * @param DateTimeImmutable $date
     * @param int[] $dayShiftUserIds
     * @param int[] $lateShiftUserIds
     * @param int[] $nightShiftUserIds
     */
    private function __construct(
        #[Getter]
        private int|null $id = null,
        #[Getter]
        private DateTimeImmutable $date,
        #[Getter]
        private array $dayShiftUserIds,
        #[Getter]
        private array $lateShiftUserIds,
        #[Getter]
        private array $nightShiftUserIds,
    ) {
    }

    /**
     * @param string $date
     * @param int[] $dayShiftUserIds
     * @param int[] $lateShiftUserIds
     * @param int[] $nightShiftUserIds
     */
    public static function create(string $date, array $dayShiftUserIds, array $lateShiftUserIds, array $nightShiftUserIds) {
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

        $isBusinessDay = !in_array($dateTimeObject->format('D'), config('closedDays.closedWeekDays')) && !in_array($dateTimeObject->format('Y-m-d'), config('closedDays.holidays'));
        if (!$isBusinessDay && count($dayShiftUserIds) < 3) {
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
