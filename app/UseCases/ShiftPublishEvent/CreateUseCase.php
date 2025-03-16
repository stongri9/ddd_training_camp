<?php

namespace app\UseCases\ShiftPublishEvent;

use app\Domains\Shift\CreateShiftContinueSpecification;
use app\Domains\Shift\CreateShiftUserRoleSpecification;
use app\Domains\Shift\IShiftRepository;
use app\Domains\ShiftPublishEvent\IShiftPublishEventRepository;
use app\Domains\ShiftPublishEvent\ShiftPublishEvent;
use DateTimeImmutable;

class CreateUseCase
{
    public function __construct(
        private readonly IShiftPublishEventRepository $shiftPublishEventRepository,
        private readonly IShiftRepository $shiftRepository,
        private readonly CreateShiftContinueSpecification $createShiftContinueSpecification,
        private readonly CreateShiftUserRoleSpecification $createShiftUserRoleSpecification,
    ) {}

    public function __invoke(CreateUseCaseDto $dto): void
    {
        $shifts = $this->shiftRepository->getShiftsByPeriod(
            new DateTimeImmutable($dto->start_date),
            new DateTimeImmutable($dto->end_date),
        );

        $errors = [];
        foreach ($shifts as $shift) {
            $errors = [
                ...$errors,
                ...$this->createShiftUserRoleSpecification->getViolations(
                    $shift->dayShiftUserIds,
                    $shift->lateShiftUserIds,
                    $shift->nightShiftUserIds,
                ),
            ];
        }
        $errors = [
            ...$errors,
            ...$this->createShiftContinueSpecification->getViolations($shifts),
        ];

        if ($errors) {
            throw new \InvalidArgumentException(implode(PHP_EOL, $errors));
        }

        $shiftPublishEvent = ShiftPublishEvent::create(
            $dto->start_date,
            $dto->end_date,
        );
        $this->shiftPublishEventRepository->create($shiftPublishEvent);
    }
}
