<?php

namespace Tests\Unit\UseCases\Shift;

use app\Domains\Shift\CreateShiftContinueSpecification;
use app\Domains\Shift\CreateShiftUserRoleSpecification;
use app\Domains\Shift\IShiftChangeApplicationRepository;
use app\Domains\Shift\IShiftRepository;
use app\Domains\Shift\Shift;
use app\Domains\Shift\ShiftChangeApplication;
use app\Domains\Shift\ShiftFactory;
use app\Domains\User\IUserRepository;
use app\UseCases\Shift\RequestChangeShiftUseCase;
use app\UseCases\Shift\RequestChangeShiftUseCaseDto;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class RequestChangeShiftUseCaseTest extends TestCase
{
    public function test_request_change_shift(): void
    {
        $shiftDate = new \DateTimeImmutable('2025-03-16');

        // モックデータの作成
        $shift = Shift::reconstruct(
            1,
            $shiftDate,
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9]
        );
        $shiftChangeApplication = Mockery::mock(ShiftChangeApplication::class);

        /** @var IUserRepository&\Mockery\MockInterface */
        $userRepository = $this->mock(IUserRepository::class);
        /** @var IShiftRepository&\Mockery\MockInterface */
        $shiftRepository = $this->mock(IShiftRepository::class);
        /** @var IShiftChangeApplicationRepository&\Mockery\MockInterface */
        $shiftChangeApplicationRepository = $this->mock(IShiftChangeApplicationRepository::class);
        /** @var ShiftFactory&\Mockery\MockInterface */
        $shiftFactory = $this->mock(ShiftFactory::class);
        /** @var CreateShiftUserRoleSpecification&\Mockery\MockInterface */
        $createShiftUserRoleSpecification = $this->mock(CreateShiftUserRoleSpecification::class);
        /** @var CreateShiftContinueSpecification&\Mockery\MockInterface */
        $createShiftContinueSpecification = $this->mock(CreateShiftContinueSpecification::class);

        $dto = RequestChangeShiftUseCaseDto::create(
            $shift,
            $shiftDate,
            [10, 11, 12],
            [13, 14, 15],
            [16, 17, 18],
            10,
            'シフト変更お願いします！'
        );

        // モック設定
        $userRepository->shouldReceive('findAll')
            ->once()
            ->andReturn(new Collection([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]));

        $previousDate = $shiftDate->modify('-1 day');
        $nextDate = $shiftDate->modify('+1 day');

        $shiftRepository->shouldReceive('getShiftByDate')
            ->once()
            ->with(Mockery::on(function ($arg) use ($previousDate) {
                return $arg == $previousDate;
            }))
            ->andReturn($shift);

        $shiftRepository->shouldReceive('getShiftByDate')
            ->once()
            ->with(Mockery::on(function ($arg) use ($nextDate) {
                return $arg == $nextDate;
            }))
            ->andReturn($shift);

        $shiftFactory->shouldReceive('create')
            ->once()
            ->with(
                Mockery::on(fn ($date) => $date == $shiftDate),
                Mockery::type(Collection::class),
                $shift,
                $shift
            )
            ->andReturn($shift);

        $createShiftUserRoleSpecification->shouldReceive('getViolations')
            ->once()
            ->with(
                $dto->requestDayShiftUserIds,   // [10, 11, 12]
                $dto->requestLateShiftUserIds,  // [13, 14, 15]
                $dto->requestNightShiftUserIds  // [16, 17, 18]
            )
            ->andReturn([]);

        $createShiftContinueSpecification->shouldReceive('getViolations')
            ->once()
            ->with(Mockery::type('Illuminate\Support\Collection'))
            ->andReturn([]);

        // リポジトリの作成メソッド
        $shiftChangeApplicationRepository->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($application) {
                return $application instanceof ShiftChangeApplication;
            }))
            ->andReturnNull();

        // UseCaseの実行
        $useCase = new RequestChangeShiftUseCase(
            $shiftRepository,
            $userRepository,
            $createShiftUserRoleSpecification,
            $createShiftContinueSpecification,
            $shiftFactory,
            $shiftChangeApplicationRepository
        );

        // 実際にUseCaseを呼び出し
        $useCase($dto);

        // 検証: リポジトリのメソッドが呼ばれたか
        $shiftChangeApplicationRepository->shouldHaveReceived('create');
    }
}
