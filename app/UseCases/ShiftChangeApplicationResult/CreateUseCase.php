<?php

namespace app\UseCases\ShiftChangeApplicationResult;

use app\Domains\ShiftChangeApplication\IShiftChangeApplicationRepository;
use app\Domains\ShiftChangeApplicationResult\IShiftChangeApplicationResultRepository;
use app\Domains\ShiftChangeApplicationResult\ShiftChangeApplicationResult;
use app\Domains\User\IUserRepository;

class CreateUseCase
{
    public function __construct(
        private readonly IShiftChangeApplicationRepository $shift_change_application_repository,
        private readonly IUserRepository $user_repository,
        private readonly IShiftChangeApplicationResultRepository $shift_change_application_result_repository,
    ) {}

    public function __invoke(CreateUseCaseDto $dto): void
    {
        if (is_null($this->shift_change_application_repository->find($dto->shift_change_application_id))) {
            throw new \InvalidArgumentException('シフト変更申請が存在しません。');
        }

        if (is_null($this->user_repository->find($dto->confirm_user_id))) {
            throw new \InvalidArgumentException('確認者が存在しません。');
        }

        $shift_change_application_result = ShiftChangeApplicationResult::create(
            $dto->shift_change_application_id,
            $dto->confirm_user_id,
            $dto->result_type,
            $dto->comment,
        );

        $this->shift_change_application_result_repository->create($shift_change_application_result);
    }
}
