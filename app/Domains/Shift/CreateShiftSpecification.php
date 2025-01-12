<?php
namespace App\Domains\Shift;

use App\Domains\BaseSpecification;
use App\Domains\User\IUserRepository;
use DateTimeImmutable;

class CreateShiftSpecification extends BaseSpecification {
    public function __construct(
        private readonly IShiftRepository $shiftRepository,
        private readonly IUserRepository $userRepository,
    ) {
    }

    /**
     * @param string $date
     * @param int[] $dayShiftUserIds
     * @param int[] $lateShiftUserIds
     * @param int[] $nightShiftUserIds
     * @return string[]
     */
    public function getViolations(
        string $date,
        array $dayShiftUserIds,
        array $lateShiftUserIds,  
        array $nightShiftUserIds,  
    ): array  {
        $violations = [];
        //７連勤以上できない
        $dateTimeObject = new DateTimeImmutable($date);
        $shifts = $this->shiftRepository->getShiftsByPeriod($dateTimeObject->modify('-6 day'), $dateTimeObject->modify('+6 day'));
        $userShiftMappings = [];
        foreach ($shifts as $shift) {
            $date = $shift->date;
            $userIds = [...$shift->dayShiftUserIds, ...$shift->lateShiftUserIds, ...$shift->nightShiftUserIds];
            foreach ($userIds as $userId) {
                if (!isset($userShiftMappings[$userId])) {
                    $userShiftMappings[$userId] = [];
                }
                $userShiftMappings[$userId][] = $date;
            }
        }

        foreach ($userShiftMappings as $dates) {
            $consecutiveWorkingDays = 0;
            $maxConsecutiveWorkingDays = 0;
            $dayBefore = null;
            foreach ($dates as $date) {
                if (isset($dayBefore) && strtotime($date) === strtotime($dayBefore . '+1 day')) {
                    $consecutiveWorkingDays++;
                } else {
                    $consecutiveWorkingDays = 1;
                }
                $maxConsecutiveWorkingDays = max($maxConsecutiveWorkingDays, $consecutiveWorkingDays);
                $dayBefore = $date;
            }
            if ($maxConsecutiveWorkingDays >= 7) {
                $violations[] = '7日以上の連勤はできません。';
                break;
            }
        }

        //日勤ルール
        $dayShiftusers = $this->userRepository->getUsersByIds($dayShiftUserIds);
        if($dayShiftusers->contains(function ($user) {
            return $user->role === 'arbeit';
        })) {
            $violations[] = '日勤にアルバイトを含めることはできません。';
        }
        if(!$dayShiftusers->contains(function ($user) {
            return in_array($user->role, ['nurse', 'associateNurse'], true);
        })) {
            $violations[] = '日勤には看護師または准看護師を1人以上含める必要があります。';
        }

        //遅番ルール
        $lateShiftusers = $this->userRepository->getUsersByIds($lateShiftUserIds);
        if($lateShiftusers->contains(function ($user) {
            return $user->role === 'arbeit';
        })) {
            $violations[] = '遅番にアルバイトを含めることはできません。';
        }
        if(!$lateShiftusers->contains(function ($user) {
            return in_array($user->role, ['nurse', 'associateNurse'], true);
        })) {
            $violations[] = '遅番には看護師または准看護師を1人以上含める必要があります。';
        }

        //夜勤ルール
        $nightShiftusers = $this->userRepository->getUsersByIds($lateShiftUserIds);
        if(!$nightShiftusers->contains(function ($user) {
            return $user->role === 'nurse';
        })) {
            $violations[] = '夜勤には看護師を1人以上含める必要があります。';
        }
        if($lateShiftusers->contains(function ($user) {
            return in_array($user->role, ['headNurse', 'chief', 'part'], true);
        })) {
            $violations[] = '夜勤に看護師長、主任、パートを含めることはできません。';
        }
        $nextDayShift = $this->shiftRepository->getShiftByDate($dateTimeObject->modify('+1 day'));
        $nextShiftUserIds = [...$nextDayShift->dayShiftUserIds, ...$nextDayShift->lateShiftUserIds, ...$nextDayShift->nightShiftUserIds];
        if (!empty(array_intersect($nextShiftUserIds, $nightShiftUserIds))){
            $violations[] = '夜勤の人は翌日は休みである必要があります。';
        };

        return $violations;
    }
}