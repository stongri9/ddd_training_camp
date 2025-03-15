<?php

namespace app\UseCases\Shift;

use app\Domains\Shift\CreateShiftContinueSpecification;
use app\Domains\Shift\CreateShiftUserRoleSpecification;
use app\Domains\Shift\IShiftRepository;
use app\Domains\Shift\ShiftFactory;
use app\Domains\User\IUserRepository;
use DateTimeImmutable;
use Illuminate\Support\Collection;

class ShowUseCase
{
    public function __construct(
        private readonly IShiftRepository $shiftRepository,
        private readonly IUserRepository $userRepository,
        private readonly CreateShiftUserRoleSpecification $createShiftUserRoleSpecification,
        private readonly CreateShiftContinueSpecification $createShiftContinueSpecification,
        private readonly ShiftFactory $shiftFactory,
    ) {}

    /**
     * @return Collection<int, \app\Domains\Shift\Shift>
     */
    public function __invoke(ShowUseCaseDto $getUseCaseDto): Collection
    {
        $firstDayOfMonth = new DateTimeImmutable("{$getUseCaseDto->year}-{$getUseCaseDto->month}-01");
        $lastDayOfMonth = $firstDayOfMonth
        ->modify('first day of next month')
        ->modify('-1 day');

        $shiftCollection = $this->shiftRepository->getShiftsByPeriod($firstDayOfMonth, $lastDayOfMonth);

        return $shiftCollection;
    }
}
