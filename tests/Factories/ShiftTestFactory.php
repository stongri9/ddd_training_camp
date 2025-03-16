<?php

namespace Tests\Factories;

use app\Domains\Shift\Shift;
use DateTimeImmutable;

class ShiftTestFactory
{
    /**
     * テスト用のShiftエンティティを作成
     */
    public static function create(
        int $id = 1,
        $date = 'now',
        array $dayShiftUserIds = [],
        array $lateShiftUserIds = [],
        array $nightShiftUserIds = []
    ): Shift {
        if (!$date instanceof DateTimeImmutable) {
            $date = new DateTimeImmutable($date);
        }

        return Shift::reconstruct($id, $date, $dayShiftUserIds, $lateShiftUserIds, $nightShiftUserIds);
    }

    /**
     * 前日シフト用のテストデータを作成
     * 夜勤者IDを明示的に指定し、テスト時に前日夜勤者が翌日シフトに入らないようにする
     */
    public static function createPreviousShift(array $nightShiftUserIds = [19, 20]): Shift
    {
        // 前日の日付を指定
        $previousDate = new DateTimeImmutable('2023-01-09'); // テスト日の前日
        
        return self::create(
            1,
            $previousDate,
            [1, 2, 3, 4],
            [5],
            $nightShiftUserIds
        );
    }

    /**
     * 翌日確定シフト用のテストデータを作成
     * 特定のユーザーIDを使用して、テスト対象の夜勤者と重複しないようにする
     */
    public static function createConfirmedNextShift(): Shift
    {
        // 翌日の日付を指定
        $nextDate = new DateTimeImmutable('2023-01-11'); // テスト日の翌日
        
        return self::create(
            2,
            $nextDate,
            [7, 8, 9, 10], // 准看護師を日勤に
            [11],          // 看護師長を遅番に
            [1, 2]         // 看護師を夜勤に
        );
    }
}
