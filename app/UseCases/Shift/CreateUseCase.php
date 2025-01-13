<?php

namespace App\UseCases\Shift;

use App\Domains\Shift\IShiftRepository;
use App\Domains\User\IUserRepository;
use App\Domains\Shift\ShiftFactory;
use App\Domains\Shift\CreateShiftSpecification;
use DateTime;
use DateTimeImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CreateUseCase {
    public function __construct(
        private readonly IShiftRepository $shiftRepository,
        private readonly IUserRepository $userRepository,
        private readonly CreateShiftSpecification $createShiftSpecification,
        private readonly ShiftFactory $shiftFactory,
    ) {}
        
    public function __invoke(CreateUseCaseDto $createUseCaseDto): void
    {
        DB::beginTransaction();
        try{
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
                    ...$this->createShiftSpecification->getViolations(
                    $shift->date,
                    $shift->dayShiftUserIds,
                    $shift->lateShiftUserIds,
                    $shift->nightShiftUserIds,
                    )
                ];
            }
            if ($errors) {
                throw new \InvalidArgumentException(implode(PHP_EOL, $errors));
            }
            $this->shiftRepository->createAll($shiftCollection);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}