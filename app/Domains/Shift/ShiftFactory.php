<?php

namespace app\Domains\Shift;

use app\Domains\User\Role;
use app\Domains\User\User;
use DateTimeInterface;
use Illuminate\Support\Collection;

class ShiftFactory
{
    /**
     * @param  Collection<int, User>  $users
     */
    public function create(DateTimeInterface $date, Collection $users, ?Shift $previousShift, ?Shift $confirmedNextShift): Shift
    {
        $canWorkUsers = $users->reject(fn (User $user) => in_array($user->id, $previousShift->nightShiftUserIds ?? [], true));

        $workDayShiftUsers = $this->determineDayShiftUsers($date, $canWorkUsers);
        $canWorkUsers = $canWorkUsers->reject(fn (User $user) => in_array($user->id, $workDayShiftUsers->pluck('id')->all(), true));

        $workLateShiftUsers = $this->determineLateShiftUsers($date, $canWorkUsers);
        $canWorkUsers = $canWorkUsers->reject(fn (User $user) => in_array($user->id, $workLateShiftUsers->pluck('id')->all(), true));

        $workNightShiftUsers = $this->determineNightShiftUsers($date, $canWorkUsers, $confirmedNextShift);

        return Shift::create(
            $date->format('Y-m-d'),
            $workDayShiftUsers->pluck('id')->all(),
            $workLateShiftUsers->pluck('id')->all(),
            $workNightShiftUsers->pluck('id')->all()
        );
    }

    /**
     * @param  Collection<int, User>  $canWorkUsers
     * @return Collection<int, User>
     */
    private function determineDayShiftUsers(DateTimeInterface $date, Collection $canWorkUsers): Collection
    {
        $numberOfDayShiftUser = $this->getNumberOfShiftUser($date, ShiftType::Day);
        $canWorkNurseOrAssociateNurseUsers = $canWorkUsers->filter(
            fn (User $user) => in_array($user->role, [Role::AssociateNurse, Role::Nurse], true)
        );
        /** @var Collection<int, User> */
        $workDayShiftNurseOrAssociateNurseUser = $canWorkNurseOrAssociateNurseUsers
            ->when(
                fn (Collection $canWorkUsers) => $canWorkUsers->count() === 0,
                fn () => throw new \InvalidArgumentException('勤務可能な看護師または准看護師の人数が足りません。')
            )
            ->random(1);

        return $workDayShiftNurseOrAssociateNurseUser->merge(
            $canWorkUsers
                ->reject(fn (User $user) => $user->id === $workDayShiftNurseOrAssociateNurseUser->first()?->id)
                ->reject(fn (User $user) => $user->role === Role::Arbeit)
                ->when(
                    fn (Collection $canWorkUsers) => $canWorkUsers->count() < $numberOfDayShiftUser - 1,
                    fn () => throw new \InvalidArgumentException('勤務可能な人の数が足りません。')
                )
                ->random($numberOfDayShiftUser - 1)
        );
    }

    /**
     * @param  Collection<int, User>  $canWorkUsers
     * @return Collection<int, User>
     */
    private function determineLateShiftUsers(DateTimeInterface $date, Collection $canWorkUsers): Collection
    {
        $numberOfLateShiftUser = $this->getNumberOfShiftUser($date, ShiftType::Late);
        if ($numberOfLateShiftUser > 0) {
            /** @var Collection<int, User> */
            return $canWorkUsers
                ->filter(fn (User $user) => in_array($user->role, [Role::AssociateNurse, Role::Nurse], true))
                ->when(
                    fn (Collection $canWorkUsers) => $canWorkUsers->count() < $numberOfLateShiftUser,
                    fn () => throw new \InvalidArgumentException('勤務可能な看護師または准看護師の人数が足りません。')
                )
                ->random($numberOfLateShiftUser);
        }

        return new Collection;
    }

    /**
     * @param  Collection<int, User>  $canWorkUsers
     * @return Collection<int, User>
     */
    private function determineNightShiftUsers(DateTimeInterface $date, Collection $canWorkUsers, ?Shift $confirmedNextShift): Collection
    {
        $numberOfNightShiftUser = $this->getNumberOfShiftUser($date, ShiftType::Night);
        $canWorkNightShiftUsers = $canWorkUsers->reject(
            fn (User $user) => in_array($user->role, [Role::HeadNurse, Role::Chief, Role::Part], true)
        );

        if (isset($confirmedNextShift)) {
            $canWorkNightShiftUsers = $canWorkNightShiftUsers->reject(
                fn (User $user) => in_array($user->id, $confirmedNextShift->userIds, true)
            );
        }

        /** @var Collection<int, User> */
        $workNightShiftNurseUser = $canWorkNightShiftUsers
            ->filter(fn (User $user) => $user->role === Role::Nurse)
            ->when(
                fn (Collection $canWorkUsers) => $canWorkUsers->count() === 0,
                fn () => throw new \InvalidArgumentException('勤務可能な看護師の人数が足りません。')
            )
            ->random(1);

        return $workNightShiftNurseUser->merge(
            $canWorkNightShiftUsers
                ->reject(fn (User $user) => $user->id === $workNightShiftNurseUser->first()?->id)
                ->when(
                    fn (Collection $canWorkUsers) => $canWorkUsers->count() < $numberOfNightShiftUser - 1,
                    fn () => throw new \InvalidArgumentException('勤務可能な看護師、准看護師もしくはアルバイトの人数が足りません。')
                )
                ->random($numberOfNightShiftUser - 1)
        );
    }

    private function getNumberOfShiftUser(DateTimeInterface $date, ShiftType $shiftType): int
    {
        /** @var string[] */
        $closedWeekDays = config('closedDays.closedWeekDays');
        /** @var string[] */
        $holidays = config('closedDays.holidays');
        $isBusinessDay =
            ! in_array(($date)->format('D'), $closedWeekDays, true)
            && ! in_array(($date)->format('Y-m-d'), $holidays, true);

        return match ($shiftType) {
            ShiftType::Day => $isBusinessDay ? 4 : 3,
            ShiftType::Late => $isBusinessDay ? 1 : 0,
            default => 2,
        };
    }
}
