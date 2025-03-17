<?php

namespace Tests\Feature\App\UseCases;

use app\Domains\User\Role;
use app\Models\Shift as ShiftModel;
use app\Models\User as UserModel;
use app\UseCases\DayOffRequest\SubmitDayOffRequestUseCase;
use app\UseCases\DayOffRequest\SubmitDayOffRequestUseCaseDto;
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
    public function 休み希望日を提出したら、休み希望日が登録される(): void
    {
        // Arrange
        $user = UserModel::factory()->create([
            'role' => Role::Nurse->value,
        ]);
        ShiftModel::factory()->create([
            'date' => '2025-03-14',
        ]);
        $dto = SubmitDayOffRequestUseCaseDto::create(
            $user->id,
            ['2025-03-15', '2025-03-16'],
        );

        // Act
        $useCase = $this->app->make(SubmitDayOffRequestUseCase::class);
        $result = $useCase($dto);

        // Assert
        $this->assertDatabaseHas('day_off_requests', [
            'id' => $result,
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseHas('day_off_request_days', [
            'day_off_request_id' => $result,
            'date' => '2025-03-15',
        ]);
        $this->assertDatabaseHas('day_off_request_days', [
            'day_off_request_id' => $result,
            'date' => '2025-03-16',
        ]);
    }

    #[Test]
    public function 休み希望日が最新のシフト確定日より前の場合は例外を投げる(): void
    {
        // Arrange
        $user = UserModel::factory()->create([
            'role' => Role::Nurse->value,
        ]);
        ShiftModel::factory()->create([
            'date' => '2025-03-14',
        ]);
        $dto = SubmitDayOffRequestUseCaseDto::create(
            $user->id,
            ['2025-03-13', '2025-03-14'],
        );

        // Assert
        $this->expectException(\InvalidArgumentException::class);

        // Act
        $useCase = $this->app->make(SubmitDayOffRequestUseCase::class);
        $useCase($dto);
    }
}
