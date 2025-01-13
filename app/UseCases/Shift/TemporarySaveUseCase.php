<?php

namespace App\UseCases\Shift;

use App\Domains\Shift\IShiftRepository;
use App\Domains\Shift\Shift;
use App\Domains\Shift\CreateShiftUserRoleSpecification;
use App\Domains\Shift\CreateShiftContinueSpecification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TemporarySaveUseCase {
    public function __construct(
        private readonly IShiftRepository $shiftRepository,
        private readonly CreateShiftUserRoleSpecification $createShiftUserRoleSpecification,
        private readonly CreateShiftContinueSpecification $createShiftContinueSpecification,
    ) {}
        
    public function __invoke(array $temporarySaveUseCaseDtos): void
    {
        DB::begintransaction();
        try{
            $shiftCollection = new Collection;
            $errors =[];
            foreach($temporarySaveUseCaseDtos as $temporarySaveUseCaseDto){
                $errors = [
                    ...$errors,
                    ...$this->createShiftUserRoleSpecification->getViolations(
                        $temporarySaveUseCaseDto->dayShiftUserIds,
                        $temporarySaveUseCaseDto->lateShiftUserIds,
                        $temporarySaveUseCaseDto->nightShiftUserIds,
                    )
                ];
                $shift = Shift::create(
                    $temporarySaveUseCaseDto->date->format('Y-m-d'), 
                    $temporarySaveUseCaseDto->dayShiftUserIds, 
                    $temporarySaveUseCaseDto->dayShiftUserIds, 
                    $temporarySaveUseCaseDto->dayShiftUserIds,
                );
                $shiftCollection->add($shift);
            }
            $errors = [
                ...$errors,
                ...$this->createShiftContinueSpecification->getViolations($shiftCollection),
            ];
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