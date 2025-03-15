<?php

namespace Tests\Unit\Domains\Shift;

use Tests\TestCase;
use App\Domains\Shift\Shift;
use Carbon\Carbon;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Mockery;

class ShiftTest extends TestCase
{
    #[Test]
    public function it_creates_shift_successfully_on_business_day()
    {
        $date = Carbon::parse('2024-03-15')->format('Y-m-d'); // 営業日 (例: 金曜日)

        // config('closedDays') をモック
        $this->mockConfig();

        $shift = Shift::create(
            $date,
            [1, 2, 3, 4], // 日勤4人
            [5],          // 遅番1人
            [6, 7]        // 夜勤2人
        );

        $this->assertInstanceOf(Shift::class, $shift);
        $this->assertEquals($date, $shift->date->format('Y-m-d'));
    }

    #[Test]
    public function it_creates_shift_successfully_on_holiday()
    {
        $date = Carbon::parse('2024-03-17')->format('Y-m-d'); // 休院日 (例: 日曜日)

        // config('closedDays') をモック
        $this->mockConfig();

        $shift = Shift::create(
            $date,
            [1, 2, 3], // 日勤3人
            [],        // 遅番0人 (休日なので不要)
            [6, 7]     // 夜勤2人
        );

        $this->assertInstanceOf(Shift::class, $shift);
        $this->assertEquals($date, $shift->date->format('Y-m-d'));
    }

    #[DataProvider('invalidShiftDataProvider')]
    #[Test]
    public function it_throws_exception_when_invalid_shift_conditions_are_met($date, $dayShiftUserIds, $lateShiftUserIds, $nightShiftUserIds, $expectedExceptionMessage)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        // config('closedDays') をモック
        $this->mockConfig();

        Shift::create($date, $dayShiftUserIds, $lateShiftUserIds, $nightShiftUserIds);
    }

    public static function invalidShiftDataProvider(): array
    {
        return [
            // --- 営業日（通常日）のバリデーション ---
            'business day - not enough day shift workers' => ['2024-03-15', [1, 2, 3], [5], [6, 7], '営業日の場合、日勤の人は4人以上必要です。'],
            'business day - not enough late shift workers' => ['2024-03-15', [1, 2, 3, 4], [], [6, 7], '営業日の場合、遅番の人は1人以上必要です。'],
            
            // --- 休診曜日（例: 木曜日）のバリデーション ---
            'closed weekday - not enough day shift workers' => ['2024-03-14', [1, 2], [], [6, 7], '休院日の場合、日勤の人は3人以上必要です。'],
    
            // --- 祝日（例: 2025-01-23）のバリデーション ---
            'holiday - not enough day shift workers' => ['2025-01-23', [1, 2], [], [6, 7], '休院日の場合、日勤の人は3人以上必要です。'],
    
            // --- 共通のバリデーション ---
            'not enough night shift workers' => ['2024-03-15', [1, 2, 3, 4], [5], [6], '夜勤の人は2人以上必要です。'],
            'invalid user id' => ['2024-03-15', [null], [5], [6, 7], '無効なユーザーIDです。'],
        ];
    }

    /**
     * config('closedDays') をモックするヘルパー
     */
    protected function mockConfig()
    {
        $mock = Mockery::mock('alias:config');

        $mock->shouldReceive('get')
            ->with('closedDays.closedWeekDays', Mockery::any())
            ->andReturn(['Thu', 'Sun']);

        $mock->shouldReceive('get')
            ->with('closedDays.holidays', Mockery::any())
            ->andReturn(['2025-01-23']);

        $this->app->instance('config', $mock);
    }
}
