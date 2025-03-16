<?php

namespace app\UseCases\Shift;

use app\Domains\Shift\CreateShiftContinueSpecification;
use app\Domains\Shift\CreateShiftUserRoleSpecification;
use app\Domains\Shift\IShiftRepository;
use app\Domains\Shift\ShiftFactory;
use app\Domains\User\IUserRepository;
use DateTime;
use DateTimeImmutable;
use Illuminate\Support\Collection;

class CreateUseCase
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
    public function __invoke(CreateUseCaseDto $createUseCaseDto): Collection
    {
        $shift_collection = new Collection;
        $users = $this->userRepository->findAll();
        $date = new DateTime($createUseCaseDto->start_date);
        $end_date = new DateTimeImmutable($createUseCaseDto->end_date);
        $previous_shift = $this->shiftRepository->getShiftByDate($date->modify('-1 day'));
        $confirmed_next_shift = null;
        // 開始日〜終了日まで1日ずつ加算しながら日ごとのシフトを作成する
        for (; $date->diff($end_date)->d !== 0; $date->modify('+1 day')) {
            if ($date->format('Y-m-d') === $end_date->format('Y-m-d')) {
                $confirmed_next_shift = $this->shiftRepository->getShiftByDate($date->modify('+1 day'));
            }
            $entity = $this->shiftFactory->create($date, $users, $previous_shift, $confirmed_next_shift);
            $shift_collection->add($entity);
            $previous_shift = $entity;
        }

        $errors = [];
        foreach ($shift_collection as $shift) {
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
            ...$this->createShiftContinueSpecification->getViolations($shift_collection),
        ];
        if ($errors) {
            throw new \InvalidArgumentException(implode(PHP_EOL, $errors));
        }

        return $shift_collection;
    }
}
