<?php

namespace Tests\Feature\App\UseCases;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\UseCases\User\SubmitDayOffRequestUseCase;
use App\UseCases\User\SubmitDayOffRequestCaseDto;
use App\Domains\User\User;
use App\Domains\Shift\Shift;
use App\Domains\User\DayOffRequest;
use App\Domains\User\SubmitDayOffRequestSpecification;
use App\Domains\User\IUserRepository;
use App\Domains\Shift\IShiftRepository;
use App\Models\DayOffRequest as ModelsDayOffRequest;
use App\Models\User as UserModel;
use Mockery;
use PHPUnit\Framework\Attributes\Test;

class SubmitDayOffRequestUseCaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
   {
       parent::setUp();
       // モックの設定
       $userRepositoryMock = Mockery::mock(IUserRepository::class);
       $userRepositoryMock->shouldReceive('findById')
           ->andReturnUsing(function ($userId) {
               return new User(
                   // Todo: モックの返り値を設定してください
               );
           });

        $submitDayOffRequestSpecificationMock = Mockery::mock(SubmitDayOffRequestSpecification::class);
        $submitDayOffRequestSpecificationMock->shouldReceive('isSatisfied')
            ->andReturn(true);
        $this->app->instance(IUserRepository::class, $userRepositoryMock);
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
            ->create();

        $action = $this->app->make(SubmitDayOffRequestUseCase::class);
        $dto = new SubmitDayOffRequestCaseDto(1, [
            '2025-02-01',
            '2025-02-02',
            '2025-02-03',
        ]);

        // Act
        $action($dto);

        // Assert
        $this->assertDatabaseHas('day_off_requests', [
            'user_id' => $user->id,
            'date' => '2025-02-01'
        ]);
        $this->assertDatabaseHas('day_off_requests', [
            'user_id' => $user->id,
            'date' => '2025-02-02'
        ]);
        $this->assertDatabaseHas('day_off_requests', [
            'user_id' => $user->id,
            'date' => '2025-02-03'
        ]);

        $this->assertDatabaseMissing('day_off_requests', [
            'user_id' => $user->id,
            'date' => '2025-01-01'
        ]);
        $this->assertDatabaseMissing('day_off_requests', [
            'user_id' => $user->id,
            'date' => '2025-01-02'
        ]);
        $this->assertDatabaseMissing('day_off_requests', [
            'user_id' => $user->id,
            'date' => '2025-01-03'
        ]);
    }
}
