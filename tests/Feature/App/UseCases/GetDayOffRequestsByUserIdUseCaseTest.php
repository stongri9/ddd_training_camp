<?php

namespace Tests\Feature\App\UseCases;

use app\Models\DayOffRequest as DayOffRequestModel;
use app\Models\User as UserModel;
use app\UseCases\DayOffRequest\GetDayOffRequestsByUserIdUseCase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GetDayOffRequestsByUserIdUseCaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function ユーザー_i_dを渡すとユーザーに紐づく休み希望日のコレクションを返す(): void
    {
        // Arrange
        $user = UserModel::factory()->create();
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
    public function ユーザー_i_dを渡すとユーザーが存在しない場合は例外を投げる(): void
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
