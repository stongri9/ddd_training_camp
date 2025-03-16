<?php

namespace Tests\Feature\App\UseCases;

use Tests\TestCase;
use app\Models\User as UserModel;
use app\Models\DayOffRequest as DayOffRequestModel;
use PHPUnit\Framework\Attributes\Test;
use app\UseCases\DayOffRequest\GetDayOffRequestsByUserIdUseCase;

class GetDayOffRequestsByUserIdUseCaseTest extends TestCase
{
  public function setUp(): void
  {
    parent::setUp();
  }
  
  #[Test]
  public function ユーザーIDを渡すとユーザーに紐づく休み希望日のコレクションを返す(): void
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
  public function ユーザーIDを渡すとユーザーが存在しない場合は例外を投げる(): void
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
