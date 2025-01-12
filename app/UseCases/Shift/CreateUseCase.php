<?php

namespace App\UseCases\Shift;

use App\Domains\Shift\IShiftRepository;
use App\Domains\Shift\Shift;
use App\Domains\Shift\CreateShiftSpecification;

class CreateUseCase {
    public function __construct(
        private readonly IShiftRepository $shiftRepository,
        private readonly CreateShiftSpecification $createShiftSpecification,
    ) {}

    public function __invoke(CreateUseCaseDto $createUseCaseDto): void
    {
        $errors = $this->createShiftSpecification->getViolations(
            $createUseCaseDto->date,
            $createUseCaseDto->dayShiftUserIds,
            $createUseCaseDto->lateShiftUserIds,
            $createUseCaseDto->nightShiftUserIds,
        );
        if ($errors) {
            throw new \InvalidArgumentException(implode(PHP_EOL, $errors));
        }
        try {
            $shift = Shift::create(
                $createUseCaseDto->date,
                $createUseCaseDto->dayShiftUserIds,
                $createUseCaseDto->lateShiftUserIds,
                $createUseCaseDto->nightShiftUserIds,
            );
            $this->shiftRepository->create($shift);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}