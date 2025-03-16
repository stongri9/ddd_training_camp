<?php

namespace Tests\Unit\UseCases\Shift;

use app\Domains\Shift\IShiftRepository;
use app\Domains\Shift\Shift;
use app\UseCases\Shift\ShowUseCase;
use app\UseCases\Shift\ShowUseCaseDto;
use DateTimeImmutable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class ShowUseCaseTest extends TestCase
{
    public function test_show_shifts(): void
    {
        $entity1 = Shift::reconstruct(
            1,
            new DateTimeImmutable('2025-06-01'),
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9]
        );

        $entity2 = Shift::reconstruct(
            2,
            new DateTimeImmutable('2025-07-03'),
            [10, 11, 12],
            [13, 14, 15],
            [16, 17, 18]
        );

        $collection = new Collection([$entity1]);

        /** @var IShiftRepository & \Mockery\MockInterface */
        $repository = $this->mock(IShiftRepository::class, function ($mock) use ($collection) {
            $mock->shouldReceive('getShiftsByPeriod')
                ->once()
                ->with(Mockery::type(DateTimeInterface::class), Mockery::type(DateTimeInterface::class))
                ->andReturn($collection);
        });

        $dto = ShowUseCaseDto::create(2025, 6);

        $useCase = new ShowUseCase($repository);
        $result = $useCase($dto);

        $this->assertSame(1, $result->count());
        $this->assertSame($entity1, $result->first());
    }
}
