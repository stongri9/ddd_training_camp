<?php

namespace app\UseCases\Shift;

use app\Domains\Shift\IShiftRepository;
use DateTimeImmutable;
use Illuminate\Support\Collection;

class ShowUseCase
{
    public function __construct(
        private readonly IShiftRepository $shiftRepository,
    ) {}

    /**
     * @return Collection<int, \app\Domains\Shift\Shift>
     */
    public function __invoke(ShowUseCaseDto $showUseCaseDto): Collection
    {
        try {
            $firstDayOfMonth = new DateTimeImmutable($showUseCaseDto->start_date);
            $endDayOfMonth = new DateTimeImmutable($showUseCaseDto->end_date);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('正しい形式の日付を指定してください。');
        }

        return $this->shiftRepository->getShiftsByPeriod(
            $firstDayOfMonth,
            $endDayOfMonth,
        );
    }
}
