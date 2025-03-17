<?php

namespace app\UseCases\Shift;

use app\Domains\Shift\CreateShiftContinueSpecification;
use app\Domains\Shift\CreateShiftUserRoleSpecification;
use app\Domains\Shift\IShiftRepository;
use app\Domains\Shift\Shift;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TemporarySaveUseCase
{
    public function __construct(
        private readonly IShiftRepository $shiftRepository,
        private readonly CreateShiftUserRoleSpecification $createShiftUserRoleSpecification,
        private readonly CreateShiftContinueSpecification $createShiftContinueSpecification,
    ) {}

    /**
     * @param  \app\UseCases\Shift\TemporarySaveUseCaseDto[]  $temporarySaveUseCaseDtos
     */
    public function __invoke(array $temporarySaveUseCaseDtos): void
    {
        DB::beginTransaction();
        if (empty($temporarySaveUseCaseDtos)) {
            throw new \InvalidArgumentException('一つ以上のシフトを登録してください');
        }

        try {
            $shiftCollection = new Collection;
            $errors = [];

            foreach ($temporarySaveUseCaseDtos as $temporarySaveUseCaseDto) {
                $errors = [
                    ...$errors,
                    ...$this->createShiftUserRoleSpecification->getViolations(
                        $temporarySaveUseCaseDto->dayShiftUserIds,
                        $temporarySaveUseCaseDto->lateShiftUserIds,
                        $temporarySaveUseCaseDto->nightShiftUserIds,
                    ),
                ];
                $shift = Shift::create(
                    $temporarySaveUseCaseDto->date->format('Y-m-d'),
                    $temporarySaveUseCaseDto->dayShiftUserIds,
                    $temporarySaveUseCaseDto->dayShiftUserIds,
                    $temporarySaveUseCaseDto->dayShiftUserIds,
                );
                $shiftCollection->add($shift);
            }

            $dateCollection = collect($temporarySaveUseCaseDtos)->map(fn ($dtom) => $temporarySaveUseCaseDto->date)->sortBy('date');
            /** @var \DateTimeImmutable */
            $firstDate = $dateCollection->first();
            /** @var \DateTimeImmutable */
            $endDate = $dateCollection->last();
            $before6dayShifts = $this->shiftRepository->getShiftsByPeriod($firstDate->modify('-7 day'), $firstDate->modify('-1 day'));
            $after6dayShifts = $this->shiftRepository->getShiftsByPeriod($endDate->modify('+1 day'), $endDate->modify('+7 day'));
            $errors = [
                ...$errors,
                ...$this->createShiftContinueSpecification->getViolations($shiftCollection, $before6dayShifts, $after6dayShifts),
            ];

            if ($errors) {
                throw new \InvalidArgumentException(implode(PHP_EOL, $errors));
            }

            $this->shiftRepository->insert($shiftCollection);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
