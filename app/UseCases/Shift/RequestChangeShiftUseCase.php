<?php

namespace app\UseCases\Shift;

use app\Domains\Shift\CreateShiftContinueSpecification;
use app\Domains\Shift\CreateShiftUserRoleSpecification;
use app\Domains\Shift\IShiftChangeApplicationRepository;
use app\Domains\Shift\IShiftRepository;
use app\Domains\Shift\ShiftChangeApplication;
use app\Domains\Shift\ShiftFactory;
use app\Domains\User\IUserRepository;
use Illuminate\Support\Collection;

class RequestChangeShiftUseCase
{
    public function __construct(
        private readonly IShiftRepository $shiftRepository,
        private readonly IUserRepository $userRepository,
        private readonly CreateShiftUserRoleSpecification $createShiftUserRoleSpecification,
        private readonly CreateShiftContinueSpecification $createShiftContinueSpecification,
        private readonly ShiftFactory $shiftFactory,
        private readonly IShiftChangeApplicationRepository $shiftChangeApplicationRepository,
    ) {}

    public function __invoke(RequestChangeShiftUseCaseDto $requestChangeShiftUseCaseDto): void
    {
        $shift_collection = new Collection;
        $users = $this->userRepository->findAll();
        $previous_shift = $this->shiftRepository->getShiftByDate($requestChangeShiftUseCaseDto->date->modify('-1 day'));
        $confirmed_next_shift = $this->shiftRepository->getShiftByDate($requestChangeShiftUseCaseDto->date->modify('+1 day'));
        $entity = $this->shiftFactory->create($requestChangeShiftUseCaseDto->date, $users, $previous_shift, $confirmed_next_shift);
        $shift_collection->add($entity);

        $errors = [
            ...$this->createShiftUserRoleSpecification->getViolations(
                $requestChangeShiftUseCaseDto->requestDayShiftUserIds,
                $requestChangeShiftUseCaseDto->requestLateShiftUserIds,
                $requestChangeShiftUseCaseDto->requestNightShiftUserIds,
                ...$this->createShiftContinueSpecification->getViolations($shift_collection),
            ),
        ];
        if ($errors) {
            throw new \InvalidArgumentException(implode(PHP_EOL, $errors));
        }
        try {
            $shiftChangeApplication = ShiftChangeApplication::create(
                $requestChangeShiftUseCaseDto->shift,
                $requestChangeShiftUseCaseDto->date,
                $requestChangeShiftUseCaseDto->requestDayShiftUserIds,
                $requestChangeShiftUseCaseDto->requestLateShiftUserIds,
                $requestChangeShiftUseCaseDto->requestNightShiftUserIds,
                $requestChangeShiftUseCaseDto->userId,
                $requestChangeShiftUseCaseDto->comment,
            );
            $this->shiftChangeApplicationRepository->create($shiftChangeApplication);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
