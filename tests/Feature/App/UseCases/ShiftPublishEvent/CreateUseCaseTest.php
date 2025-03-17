<?php

namespace Tests\Feature\App\UseCases\ShiftPublishEvent;

use app\UseCases\ShiftPublishEvent\CreateUseCase;
use app\UseCases\ShiftPublishEvent\CreateUseCaseDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateUseCaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function ユースケースを実行すると、シフト公開イベントが_d_bに保存される(): void
    {
        // Arrange
        $start_date = '2025-01-01';
        $end_date = '2025-01-31';
        $dto = CreateUseCaseDto::create($start_date, $end_date);

        // Act
        $useCase = $this->app->make(CreateUseCase::class);
        $useCase($dto);

        // Assert
        $this->assertDatabaseHas('shift_publish_events', [
            'start_date' => '2025-01-01 00:00:00',
            'end_date' => '2025-01-31 00:00:00',
        ]);
    }
}
