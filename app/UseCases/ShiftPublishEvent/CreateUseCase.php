<?php

namespace app\UseCases\ShiftPublishEvent;

use app\Domains\ShiftPublishEvent\IShiftPublishEventRepository;
use app\Domains\ShiftPublishEvent\ShiftPublishEvent;
use DateTimeImmutable;

class CreateUseCase
{
    public function __construct(
        private readonly IShiftPublishEventRepository $shiftPublishEventRepository,
    ) {}

    public function __invoke(CreateUseCaseDto $dto): void
    {
        $shiftPublishEvent = ShiftPublishEvent::create(
            new DateTimeImmutable($dto->start_date),
            new DateTimeImmutable($dto->end_date),
        );

        $this->shiftPublishEventRepository->create($shiftPublishEvent);
    }
}
