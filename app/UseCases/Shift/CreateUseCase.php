<?php

namespace App\UseCases\Shift;

use App\Domains\Shift\IShiftRepository;
use App\Domains\User\IUserRepository;
use App\Domains\Shift\ShiftFactory;
use App\Domains\Shift\CreateShiftUserRoleSpecification;
use App\Domains\Shift\CreateShiftContinueSpecification;
use DateTime;
use DateTimeImmutable;
use Illuminate\Support\Collection;

class CreateUseCase {
    public function __construct(
        private readonly IShiftRepository $shiftRepository,
        private readonly IUserRepository $userRepository,
        private readonly CreateShiftUserRoleSpecification $createShiftUserRoleSpecification,
        private readonly CreateShiftContinueSpecification $createShiftContinueSpecification,
        private readonly ShiftFactory $shiftFactory,
    ) {}
        
    public function __invoke(CreateUseCaseDto $createUseCaseDto): Collection
    {
        $shiftCollection = new Collection();
        $users = $this->userRepository->findAll();
        $date = new DateTime($createUseCaseDto->startDate);
        $endDate = new DateTimeImmutable($createUseCaseDto->endDate);
        $previousShift = $this->shiftRepository->getShiftByDate($date->modify('-1 day'));
        $confirmedNextShift = null;
        //開始日〜終了日まで1日ずつ加算しながら日ごとのシフトを作成する
        for(; $date->diff($endDate)->d !== 0; $date->modify('+1 day')) {
            if ($date === $endDate) {
                $confirmedNextShift = $this->shiftRepository->getShiftByDate($date->modify('+1 day'));
            }
            $entity = $this->shiftFactory->create($date, $users, $previousShift, $confirmedNextShift);
            $shiftCollection->add($entity);
            $previousShift = $entity;
        }

        $errors =[];
        foreach($shiftCollection as $shift){
            $errors = [
                ...$errors,
                ...$this->createShiftUserRoleSpecification->getViolations(
                    $shift->dayShiftUserIds,
                    $shift->lateShiftUserIds,
                    $shift->nightShiftUserIds,
                )
            ];
        }
        $errors = [
            ...$errors,
            ...$this->createShiftContinueSpecification->getViolations($shiftCollection),
        ];
        if ($errors) {
            throw new \InvalidArgumentException(implode(PHP_EOL, $errors));
        }
        return $shiftCollection;
    }
}