<?php

namespace Tests\Unit\Domains\DayOffRequest;

use app\Domains\DayOffRequest\SubmitDayOffRequestSpecification;
use app\Domains\Shift\IShiftRepository;
use app\Models\Shift as ShiftModel;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SubmitDayOffRequestSpecificationTest extends TestCase
{
    /**
     * @var MockInterface|IShiftRepository
     */
    private $mockShiftRepository;

    /**
     * @var MockInterface|ShiftModel
     */
    private $mockShift;

    protected function setUp(): void
    {
        $this->mockShiftRepository = Mockery::mock(IShiftRepository::class);

        // @phpstan-ignore-next-line
        $this->mockShift = Mockery::mock(ShiftModel::class);
        // @phpstan-ignore-next-line
        $this->mockShift->shouldReceive('getAttribute')
            ->with('date')
            ->andReturn('2025-03-14');
    }

    #[Test]
    public function まだ一つもシフトが作成されていない場合はtrueを返す(): void
    {
        // Arrange
        // @phpstan-ignore-next-line
        $this->mockShiftRepository->shouldReceive('getLatestShift')->andReturn(null);

        // @phpstan-ignore-next-line
        $specification = new SubmitDayOffRequestSpecification($this->mockShiftRepository);

        $result = $specification->isSatisfied(['2025-03-14']);

        $this->assertTrue($result);
    }

    #[Test]
    public function 休み希望日に最新のシフト確定日より前の日付が含まれていない場合はtrueを返す(): void
    {
        // Arrange
        // @phpstan-ignore-next-line
        $this->mockShiftRepository->shouldReceive('getLatestShift')->andReturn(
            $this->mockShift
        );

        // @phpstan-ignore-next-line
        $specification = new SubmitDayOffRequestSpecification($this->mockShiftRepository);

        $result = $specification->isSatisfied(['2025-03-15']);

        $this->assertTrue($result);
    }

    #[Test]
    public function 休み希望日に最新のシフト確定日より前の日付が含まれている場合はfalseを返す(): void
    {
        // Arrange
        // @phpstan-ignore-next-line
        $this->mockShiftRepository->shouldReceive('getLatestShift')->andReturn(
            $this->mockShift
        );

        // @phpstan-ignore-next-line
        $specification = new SubmitDayOffRequestSpecification($this->mockShiftRepository);

        $result = $specification->isSatisfied(['2025-03-13']);

        $this->assertFalse($result);
    }
}
