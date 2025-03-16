<?php

namespace Tests\Unit\Domains\Shift;

use app\Domains\Shift\ShiftFactory;
use app\Domains\User\Role;
use DateTime;
use Tests\Factories\ShiftTestFactory;
use Tests\Factories\UserTestFactory;
use Tests\TestCase;

class ShiftFactoryTest extends TestCase
{
    private ShiftFactory $shiftFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->shiftFactory = new ShiftFactory;

        // 設定ファイルのモック - 明示的に日付を指定
        config(['closedDays.closedWeekDays' => ['Sat', 'Sun']]);
        config(['closedDays.holidays' => ['2023-01-01', '2023-01-09']]);
    }

    public function test_create_shift_on_business_day()
    {
        // 営業日のテスト (平日)
        $date = new DateTime('2023-01-10'); // 火曜日
        $users = UserTestFactory::createTestUsers();
        $previousShift = ShiftTestFactory::createPreviousShift();

        $shift = $this->shiftFactory->create($date, $users, $previousShift, null);

        // 営業日は日勤4人、遅番1人、夜勤2人であることを確認
        $this->assertCount(4, $shift->dayShiftUserIds);
        $this->assertCount(1, $shift->lateShiftUserIds);
        $this->assertCount(2, $shift->nightShiftUserIds);

        // 日勤に少なくとも1人の看護師または准看護師が含まれていることを確認
        $this->assertShiftContainsNurseOrAssociateNurse($users, $shift->dayShiftUserIds);

        // 日勤にアルバイトが含まれていないことを確認
        $this->assertShiftDoesNotContainRole($users, $shift->dayShiftUserIds, Role::Arbeit);

        // 遅番に少なくとも1人の看護師または准看護師が含まれていることを確認
        $this->assertShiftContainsNurseOrAssociateNurse($users, $shift->lateShiftUserIds);

        // 遅番にアルバイトが含まれていないことを確認
        $this->assertShiftDoesNotContainRole($users, $shift->lateShiftUserIds, Role::Arbeit);

        // 夜勤に少なくとも1人の看護師が含まれていることを確認
        $this->assertShiftContainsNurse($users, $shift->nightShiftUserIds);

        // 夜勤に看護師長、主任、パートが含まれていないことを確認
        $this->assertShiftDoesNotContainRole($users, $shift->nightShiftUserIds, Role::HeadNurse);
        $this->assertShiftDoesNotContainRole($users, $shift->nightShiftUserIds, Role::Chief);
        $this->assertShiftDoesNotContainRole($users, $shift->nightShiftUserIds, Role::Part);

        // 前日の夜勤者が当日のシフトに含まれていないことを確認
        foreach ($previousShift->nightShiftUserIds as $nightShiftUserId) {
            $this->assertNotContains($nightShiftUserId, $shift->userIds);
        }
    }

    public function test_create_shift_on_closed_day()
    {
        // 休院日のテスト (土曜日)
        $date = new DateTime('2023-01-14'); // 土曜日
        $users = UserTestFactory::createTestUsers();
        $previousShift = ShiftTestFactory::createPreviousShift();

        $shift = $this->shiftFactory->create($date, $users, $previousShift, null);

        // 休院日は日勤3人、遅番0人、夜勤2人であることを確認
        $this->assertCount(3, $shift->dayShiftUserIds);
        $this->assertCount(0, $shift->lateShiftUserIds);
        $this->assertCount(2, $shift->nightShiftUserIds);

        // 日勤に少なくとも1人の看護師または准看護師が含まれていることを確認
        $this->assertShiftContainsNurseOrAssociateNurse($users, $shift->dayShiftUserIds);

        // 日勤にアルバイトが含まれていないことを確認
        $this->assertShiftDoesNotContainRole($users, $shift->dayShiftUserIds, Role::Arbeit);

        // 夜勤に少なくとも1人の看護師が含まれていることを確認
        $this->assertShiftContainsNurse($users, $shift->nightShiftUserIds);

        // 夜勤に看護師長、主任、パートが含まれていないことを確認
        $this->assertShiftDoesNotContainRole($users, $shift->nightShiftUserIds, Role::HeadNurse);
        $this->assertShiftDoesNotContainRole($users, $shift->nightShiftUserIds, Role::Chief);
        $this->assertShiftDoesNotContainRole($users, $shift->nightShiftUserIds, Role::Part);
    }

    public function test_create_shift_with_confirmed_next_shift()
    {
        $date = new DateTime('2023-01-10');
        $users = UserTestFactory::createTestUsers();
        $previousShift = ShiftTestFactory::createPreviousShift();
        $confirmedNextShift = ShiftTestFactory::createConfirmedNextShift();

        $shift = $this->shiftFactory->create($date, $users, $previousShift, $confirmedNextShift);

        // 夜勤者が翌日のシフトに含まれていないことを確認
        foreach ($shift->nightShiftUserIds as $nightShiftUserId) {
            $this->assertNotContains($nightShiftUserId, [
                ...$confirmedNextShift->dayShiftUserIds,
                ...$confirmedNextShift->lateShiftUserIds,
                ...$confirmedNextShift->nightShiftUserIds,
            ]);
        }

        // 各シフトが適切なロール要件を満たしていることを確認
        $this->assertShiftContainsNurseOrAssociateNurse($users, $shift->dayShiftUserIds);
        $this->assertShiftDoesNotContainRole($users, $shift->dayShiftUserIds, Role::Arbeit);
        $this->assertShiftContainsNurseOrAssociateNurse($users, $shift->lateShiftUserIds);
        $this->assertShiftDoesNotContainRole($users, $shift->lateShiftUserIds, Role::Arbeit);
        $this->assertShiftContainsNurse($users, $shift->nightShiftUserIds);
        $this->assertShiftDoesNotContainRole($users, $shift->nightShiftUserIds, Role::HeadNurse);
        $this->assertShiftDoesNotContainRole($users, $shift->nightShiftUserIds, Role::Chief);
        $this->assertShiftDoesNotContainRole($users, $shift->nightShiftUserIds, Role::Part);
    }

    // ヘルパーメソッド
    private function assertShiftContainsNurseOrAssociateNurse(\Illuminate\Support\Collection $users, array $shiftUserIds): void
    {
        $hasNurseOrAssociateNurse = false;
        foreach ($shiftUserIds as $userId) {
            $user = $users->firstWhere('id', $userId);
            if (in_array($user->role, [Role::Nurse, Role::AssociateNurse], true)) {
                $hasNurseOrAssociateNurse = true;
                break;
            }
        }
        $this->assertTrue($hasNurseOrAssociateNurse, '看護師または准看護師が含まれていません');
    }

    private function assertShiftContainsNurse(\Illuminate\Support\Collection $users, array $shiftUserIds): void
    {
        $hasNurse = false;
        foreach ($shiftUserIds as $userId) {
            $user = $users->firstWhere('id', $userId);
            if ($user->role === Role::Nurse) {
                $hasNurse = true;
                break;
            }
        }
        $this->assertTrue($hasNurse, '看護師が含まれていません');
    }

    private function assertShiftDoesNotContainRole(\Illuminate\Support\Collection $users, array $shiftUserIds, Role $role): void
    {
        $containsRole = false;
        foreach ($shiftUserIds as $userId) {
            $user = $users->firstWhere('id', $userId);
            if ($user->role === $role) {
                $containsRole = true;
                break;
            }
        }
        $this->assertFalse($containsRole, $role->name.'が含まれています');
    }
}
