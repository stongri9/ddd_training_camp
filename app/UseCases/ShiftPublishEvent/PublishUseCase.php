<?php

namespace app\UseCases\ShiftPublishEvent;

use app\UseCases\Shift\TemporarySaveUseCase;
use app\UseCases\Shift\TemporarySaveUseCaseDto;
use DateTimeImmutable;

class PublishUseCase
{
    public function __construct(
        private readonly TemporarySaveUseCase $temporarySaveUseCase,
        private readonly CreateUseCase $createUseCase,
    ) {}

    public function __invoke(PublishUseCaseDto $dto): void
    {
        if (empty($dto->shifts)) {
            throw new \InvalidArgumentException('公開するシフトがありません。');
        }

        // シフト保存ユースケースの呼び出し
        $temporarySaveUseCaseDtos = array_map(function (array $shift) {
            return TemporarySaveUseCaseDto::create(
                new DateTimeImmutable($shift['date']),
                $shift['dayShiftUserIds'],
                $shift['lateShiftUserIds'],
                $shift['nightShiftUserIds'],
            );
        }, $dto->shifts);

        ($this->temporarySaveUseCase)($temporarySaveUseCaseDtos);

        // シフト公開イベント保存ユースケースの呼び出し
        $dates = array_map(fn ($temporarySaveUseCaseDto) => $temporarySaveUseCaseDto->date, $temporarySaveUseCaseDtos);

        $createUseCaseDto = CreateUseCaseDto::create(
            min($dates)->format('Y-m-d'),
            max($dates)->format('Y-m-d')
        );
        ($this->createUseCase)($createUseCaseDto);
    }
}
