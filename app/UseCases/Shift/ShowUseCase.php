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
    public function __invoke(ShowUseCaseDto $getUseCaseDto): Collection
    {
        try {
            $firstDayOfMonth = new DateTimeImmutable("{$getUseCaseDto->year}-{$getUseCaseDto->month}-01");
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('正しい形式の日付を指定してください。');
        }
        $lastDayOfMonth = $firstDayOfMonth
            ->modify('first day of next month')
            ->modify('-1 day');

        $shiftCollection = $this->shiftRepository->getShiftsByPeriod($firstDayOfMonth, $lastDayOfMonth);

        return $shiftCollection;
    }
}
