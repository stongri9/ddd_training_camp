<?php

namespace app\Domains\Shift;

use app\Domains\User\IUserRepository;
use app\Domains\User\Role;

class CreateShiftUserRoleSpecification
{
    public function __construct(
        private readonly IUserRepository $userRepository,
    ) {}

    /**
     * @param  int[]  $dayShiftUserIds
     * @param  int[]  $lateShiftUserIds
     * @param  int[]  $nightShiftUserIds
     * @return string[]
     */
    public function getViolations(
        array $dayShiftUserIds,
        array $lateShiftUserIds,
        array $nightShiftUserIds,
    ): array {
        $violations = [];

        // 日勤ルール
        $dayShiftUsers = $this->userRepository->getUsersByIds($dayShiftUserIds);
        if ($dayShiftUsers->count() > 0) {
            if ($dayShiftUsers->contains(fn ($user) => $user->role === Role::Arbeit)) {
                $violations[] = '日勤にアルバイトを含めることはできません。';
            }
            if (! $dayShiftUsers->contains(fn ($user) => in_array($user->role, [Role::Nurse, Role::AssociateNurse], true))) {
                $violations[] = '日勤には看護師または准看護師を1人以上含める必要があります。';
            }
        }

        // 遅番ルール
        $lateShiftUsers = $this->userRepository->getUsersByIds($lateShiftUserIds);
        if ($lateShiftUsers->count() > 0) {
            if ($lateShiftUsers->contains(fn ($user) => $user->role === Role::Arbeit)) {
                $violations[] = '遅番にアルバイトを含めることはできません。';
            }
            if (! $lateShiftUsers->contains(fn ($user) => in_array($user->role, [Role::Nurse, Role::AssociateNurse], true))) {
                $violations[] = '遅番には看護師または准看護師を1人以上含める必要があります。';
            }
        }

        // 夜勤ルール
        $nightShiftUsers = $this->userRepository->getUsersByIds($nightShiftUserIds);
        if ($nightShiftUsers->count() > 0) {
            if (! $nightShiftUsers->contains(fn ($user) => $user->role === Role::Nurse)) {
                $violations[] = '夜勤には看護師を1人以上含める必要があります。';
            }
            if ($nightShiftUsers->contains(fn ($user) => in_array($user->role, [Role::HeadNurse, Role::Chief, Role::Part], true))) {
                $violations[] = '夜勤に看護師長、主任、パートを含めることはできません。';
            }
        }

        return $violations;
    }
}
