<?php

namespace Tests\Feature\App\UseCases;

use App\Models\DayOffRequest as ModelsDayOffRequest;
use App\Models\User as UserModel;
use App\UseCases\User\SubmitDayOffRequestUseCase;
use App\UseCases\User\SubmitDayOffRequestUseCaseDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SubmitDayOffRequestUseCaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function 休み希望日を提出したら、ユーザーに紐づく休み希望日が更新される(): void
    {
        // Arrange
        $user = UserModel::factory()
            ->has(
                ModelsDayOffRequest::factory()
                    ->count(3)
                    ->sequence(
                        ['date' => '2025-01-01'],
                        ['date' => '2025-01-02'],
                        ['date' => '2025-01-03'],
                    )
            )
            ->createOne();

        $action = $this->app->make(SubmitDayOffRequestUseCase::class);

        $dto = SubmitDayOffRequestUseCaseDto::create($user->id, [
            '2025-02-01',
            '2025-02-02',
            '2025-02-03',
        ]);

        // Act
        $action($dto);

        // Assert
        $this->assertDatabaseHas('day_off_requests', [
            'user_id' => $user->id,
            'date' => '2025-02-01',
        ]);
        $this->assertDatabaseHas('day_off_requests', [
            'user_id' => $user->id,
            'date' => '2025-02-02',
        ]);
        $this->assertDatabaseHas('day_off_requests', [
            'user_id' => $user->id,
            'date' => '2025-02-03',
        ]);

        $this->assertDatabaseMissing('day_off_requests', [
            'user_id' => $user->id,
            'date' => '2025-01-01',
        ]);
        $this->assertDatabaseMissing('day_off_requests', [
            'user_id' => $user->id,
            'date' => '2025-01-02',
        ]);
        $this->assertDatabaseMissing('day_off_requests', [
            'user_id' => $user->id,
            'date' => '2025-01-03',
        ]);
    }
}
