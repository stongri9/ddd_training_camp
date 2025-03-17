<?php

namespace app\UseCases\ShiftPublishEvent;

use app\Domains\ShiftPublishEvent\IShiftPublishEventRepository;
use app\Domains\ShiftPublishEvent\ShiftPublishEvent;

class CreateUseCase
{
    public function __construct(
        private readonly IShiftPublishEventRepository $shiftPublishEventRepository,
    ) {}

    public function __invoke(CreateUseCaseDto $dto): void
    {
        try {
            $shiftPublishEvent = ShiftPublishEvent::create(
                $dto->start_date,
                $dto->end_date,
            );
        } catch (\Exception $e) {
            throw $e;
        }

        $this->shiftPublishEventRepository->create($shiftPublishEvent);
    }
}
