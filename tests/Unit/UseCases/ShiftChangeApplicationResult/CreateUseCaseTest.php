<?php

namespace Tests\Unit\UseCases\ShiftChangeApplicationResult;

use app\Domains\ShiftChangeApplication\IShiftChangeApplicationRepository;
use app\Domains\ShiftChangeApplicationResult\IShiftChangeApplicationResultRepository;
use app\Domains\ShiftChangeApplicationResult\ShiftChangeApplicationResult;
use app\Domains\User\IUserRepository;
use app\UseCases\ShiftChangeApplicationResult\CreateUseCase;
use app\UseCases\ShiftChangeApplicationResult\CreateUseCaseDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\Factories\ShiftChangeApplicationTestFactory;
use Tests\Factories\UserTestFactory;

class CreateUseCaseTest extends TestCase
{
    private $shiftChangeApplicationRepository;

    private $userRepository;

    private $shiftChangeApplicationResultRepository;

    private $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->shiftChangeApplicationRepository = Mockery::mock(IShiftChangeApplicationRepository::class);
        $this->userRepository = Mockery::mock(IUserRepository::class);
        $this->shiftChangeApplicationResultRepository = Mockery::mock(IShiftChangeApplicationResultRepository::class);

        $this->useCase = new CreateUseCase(
            $this->shiftChangeApplicationRepository,
            $this->userRepository,
            $this->shiftChangeApplicationResultRepository
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_create_success(): void
    {
        // テストデータ
        $applicationId = 1;
        $confirmUserId = 2;
        $resultType = 'Approved';
        $comment = 'コメント';

        // DTOの作成
        $dto = CreateUseCaseDto::create(
            $applicationId,
            $confirmUserId,
            $resultType,
            $comment
        );

        // モックの設定
        $this->shiftChangeApplicationRepository
            ->shouldReceive('find')
            ->with($applicationId)
            ->once()
            ->andReturn(ShiftChangeApplicationTestFactory::create($confirmUserId));

        $this->userRepository
            ->shouldReceive('find')
            ->with($confirmUserId)
            ->once()
            ->andReturn(UserTestFactory::create($confirmUserId));

        $this->shiftChangeApplicationResultRepository
            ->shouldReceive('create')
            ->once()
            ->andReturnUsing(function ($result) {
                $this->assertInstanceOf(ShiftChangeApplicationResult::class, $result);

                return true;
            });

        // 実行
        ($this->useCase)($dto);
    }

    public function test_create_fails_when_application_not_found(): void
    {
        // テストデータ
        $applicationId = 999; // 存在しないID
        $confirmUserId = 2;
        $resultType = 'Approved';
        $comment = 'コメント';

        // DTOの作成
        $dto = CreateUseCaseDto::create(
            $applicationId,
            $confirmUserId,
            $resultType,
            $comment
        );

        // モックの設定
        $this->shiftChangeApplicationRepository
            ->shouldReceive('find')
            ->with($applicationId)
            ->once()
            ->andReturnNull();

        // 例外が発生することを期待
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('シフト変更申請が存在しません。');

        // 実行
        ($this->useCase)($dto);
    }

    public function test_create_fails_when_user_not_found(): void
    {
        // テストデータ
        $applicationId = 1;
        $confirmUserId = 999; // 存在しないID
        $resultType = 'Approved';
        $comment = 'コメント';

        // DTOの作成
        $dto = CreateUseCaseDto::create(
            $applicationId,
            $confirmUserId,
            $resultType,
            $comment
        );

        // モックの設定
        $this->shiftChangeApplicationRepository
            ->shouldReceive('find')
            ->with($applicationId)
            ->once()
            ->andReturn(ShiftChangeApplicationTestFactory::create($confirmUserId));

        $this->userRepository
            ->shouldReceive('find')
            ->with($confirmUserId)
            ->once()
            ->andReturnNull(); // 存在しない場合はnullを返す

        // 例外が発生することを期待
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('確認者が存在しません。');

        // 実行
        ($this->useCase)($dto);
    }
}
