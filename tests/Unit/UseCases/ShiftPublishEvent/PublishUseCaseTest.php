<?php

namespace tests\Unit\UseCases\ShiftPublishEvent;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use app\UseCases\ShiftPublishEvent\PublishUseCase;
use app\UseCases\Shift\TemporarySaveUseCase;
use app\UseCases\ShiftPublishEvent\CreateUseCase;
use app\UseCases\ShiftPublishEvent\PublishUseCaseDto;
use Mockery;

class PublishUseCaseTest extends TestCase
{
  public function setUp(): void
  {
    parent::setUp();
  }

  #[Test]
  public function 引数を渡すとシフトの保存アクションと公開イベントの保存アクションを実行する(): void
  {
    // Arrange
    $spyTemporarySaveUseCase = Mockery::spy(TemporarySaveUseCase::class);
    $spyCreateUseCase = Mockery::spy(CreateUseCase::class);

    // Act
    $dto = PublishUseCaseDto::create([
      [
        'id' => 1,
        'date' => '2025-01-01',
        'dayShiftUserIds' => [1, 2],
        'lateShiftUserIds' => [3, 4],
        'nightShiftUserIds' => [5, 6],
      ],
      [
        'id' => 2,
        'date' => '2025-01-02',
        'dayShiftUserIds' => [7, 8],
        'lateShiftUserIds' => [9, 10],
        'nightShiftUserIds' => [11, 12],
      ],
    ]);

    $publishUseCase = new PublishUseCase($spyTemporarySaveUseCase, $spyCreateUseCase);
    $publishUseCase($dto);

    // Assert
    $spyTemporarySaveUseCase->shouldHaveReceived('__invoke');
    $spyCreateUseCase->shouldHaveReceived('__invoke');
    $this->assertTrue(true, 'シフト公開シナリオユースケースが正常に実行されました');
    Mockery::close();
  }

  protected function tearDown(): void
  {
    Mockery::close();
    parent::tearDown();
  }
}
