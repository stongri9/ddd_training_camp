<?php

namespace Tests\Unit\Domains\User;

use app\Domains\User\ExistUserSpecification;
use app\Domains\User\IUserRepository;
use app\Models\User;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ExistUserSpecificationTest extends TestCase
{
    /**
     * @var MockInterface|IUserRepository
     */
    private $mockUserRepository;

    /**
     * @var ExistUserSpecification
     */
    private $existUserSpecification;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockUserRepository = Mockery::mock(IUserRepository::class);
        $this->existUserSpecification = new ExistUserSpecification($this->mockUserRepository);
    }

    public function 渡されたユーザーIDを持つユーザーが存在する場合はtrueを返す(): void
    {
        // Arrange
        $userId = 1;
        $user = Mockery::mock(User::class);
        $this->mockUserRepository->shouldReceive('find')->with($userId)->andReturn($user);

        // Act
        $result = $this->existUserSpecification->isSatisfied($userId);

        // Assert
        $this->assertTrue($result);
    }

    public function 渡されたユーザーIDを持つユーザーが存在しない場合はfalseを返す(): void
    {
        // Arrange
        $userId = 1;
        $this->mockUserRepository->shouldReceive('find')->with($userId)->andReturn(null);

        // Act
        $result = $this->existUserSpecification->isSatisfied($userId);

        // Assert
        $this->assertFalse($result);
    }
}
