<?php

namespace app\UseCases\DayOffRequest;

use app\Domains\DayOffRequest\IDayOffRequestRepository;
// use app\Domains\User\SubmitDayOffRequestSpecification;
use app\Domains\DayOffRequest\DayOffRequest;
use InvalidArgumentException;

class SubmitDayOffRequestUseCase
{
    public function __construct(
        private readonly IDayOffRequestRepository $dayOffRequestRepository,
        // private readonly SubmitDayOffRequestSpecification $submitDayOffRequestSpecification
    ) {}

    /**
     * @param  SubmitDayOffRequestUseCaseDto  $dto
     * @return int
     */
    public function __invoke(SubmitDayOffRequestUseCaseDto $dto): int
    {
        // TODO: Shiftモデルを取り込んだらシフト確定日以降の日付を申請しているか確認するSpecificationを追加する

        $dayOffRequest = DayOffRequest::create(
            $dto->day_off_request_days,
            $dto->user_id,
        );

        try {
            return $this->dayOffRequestRepository->create($dayOffRequest);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
