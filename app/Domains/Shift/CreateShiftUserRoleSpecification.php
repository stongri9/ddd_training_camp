<?php
namespace App\Domains\Shift;

use App\Domains\User\IUserRepository;

class CreateShiftUserRoleSpecification {
    public function __construct(
        private readonly IUserRepository $userRepository,
    ) {
    }

    /**
     * @param int[] $dayShiftUserIds
     * @param int[] $lateShiftUserIds
     * @param int[] $nightShiftUserIds
     * @return string[]
     */
    public function getViolations(
        array $dayShiftUserIds,
        array $lateShiftUserIds,  
        array $nightShiftUserIds,  
    ): array  {
        $violations = [];

        //日勤ルール
        $dayShiftusers = $this->userRepository->getUsersByIds($dayShiftUserIds);
        if($dayShiftusers->contains(fn ($user) => $user->role === 'arbeit')) {
            $violations[] = '日勤にアルバイトを含めることはできません。';
        }
        if(!$dayShiftusers->contains(fn ($user) => in_array($user->role, ['nurse', 'associateNurse'], true))) {
            $violations[] = '日勤には看護師または准看護師を1人以上含める必要があります。';
        }

        //遅番ルール
        $lateShiftusers = $this->userRepository->getUsersByIds($lateShiftUserIds);
        if($lateShiftusers->contains(fn ($user) => $user->role === 'arbeit')) {
            $violations[] = '遅番にアルバイトを含めることはできません。';
        }
        if(!$lateShiftusers->contains(fn ($user) => in_array($user->role, ['nurse', 'associateNurse'], true))) {
            $violations[] = '遅番には看護師または准看護師を1人以上含める必要があります。';
        }

        //夜勤ルール
        $nightShiftusers = $this->userRepository->getUsersByIds($nightShiftUserIds);
        if(!$nightShiftusers->contains(fn ($user) => $user->role === 'nurse')) {
            $violations[] = '夜勤には看護師を1人以上含める必要があります。';
        }
        if($lateShiftusers->contains(fn ($user) => in_array($user->role, ['headNurse', 'chief', 'part'], true))) {
            $violations[] = '夜勤に看護師長、主任、パートを含めることはできません。';
        }
        return $violations;
    }
}