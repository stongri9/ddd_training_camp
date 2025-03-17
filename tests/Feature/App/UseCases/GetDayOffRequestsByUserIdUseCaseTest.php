<?php

namespace Tests\Feature\App\UseCases;

use app\Domains\User\Role;
use app\Models\DayOffRequest as DayOffRequestModel;
use app\Models\User as UserModel;
use app\UseCases\DayOffRequest\GetDayOffRequestsByUserIdUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetDayOffRequestsByUserIdUseCaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function ユーザーidを渡すとユーザーに紐づく休み希望日のコレクションを返す(): void
    {
        // Arrange
        $user = UserModel::factory()->create([
            'role' => Role::Nurse->value,
        ]);
        DayOffRequestModel::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        // Act
        $useCase = $this->app->make(GetDayOffRequestsByUserIdUseCase::class);
        $result = $useCase($user->id);

        // Assert
        $this->assertCount(3, $result);
    }

    #[Test]
    public function ユーザーが存在しない場合は例外を投げる(): void
    {
        // Arrange
        $userId = 999999;

        // Assert
        $this->expectException(\InvalidArgumentException::class);

        // Act
        $useCase = $this->app->make(GetDayOffRequestsByUserIdUseCase::class);
        $useCase($userId);
    }
}
