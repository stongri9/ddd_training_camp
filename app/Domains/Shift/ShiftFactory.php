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
        $canWorkUsers = $users->filter(
            fn (User $user) => ! in_array($date, $user->dayOffRequests, true)
                && ! in_array($user->id, $previousShift->nightShiftUserIds ?? [], true)
        );

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
        $numberOfDayShiftUser = $this->getNumberOfShiftUser($date, 'day');
        $canWorkNurseOrAssociateNurseUsers = $canWorkUsers->filter(
            fn (User $user) => in_array($user->role, [Role::AssociateNurse, Role::Nurse], true)
        );
        /** @var Collection<int, User> */
        $workDayShiftNurseOrAssociateNurseUser = $canWorkNurseOrAssociateNurseUsers->random(1);

        return $workDayShiftNurseOrAssociateNurseUser->add(
            $canWorkUsers
                ->reject(fn (User $user) => $user->id === $workDayShiftNurseOrAssociateNurseUser->first()?->id)
                ->random($numberOfDayShiftUser - 1)
        );
    }

    /**
     * @param  Collection<int, User>  $canWorkUsers
     * @return Collection<int, User>
     */
    private function determineLateShiftUsers(DateTimeInterface $date, Collection $canWorkUsers): Collection
    {
        $numberOfLateShiftUser = $this->getNumberOfShiftUser($date, 'late');
        if ($numberOfLateShiftUser > 0) {
            /** @var Collection<int, User> */
            return $canWorkUsers
                ->filter(fn (User $user) => in_array($user->role, [Role::AssociateNurse, Role::Nurse], true))
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
        $numberOfNightShiftUser = $this->getNumberOfShiftUser($date, 'night');
        $canWorkNightShiftUsers = $canWorkUsers->reject(
            fn (User $user) => in_array($user->role, [Role::HeadNurse, Role::Chief, Role::Part], true)
        );

        if (isset($confirmedNextShift)) {
            $canWorkNightShiftUsers = $canWorkNightShiftUsers->reject(
                fn (User $user) => in_array(
                    $user->id,
                    [
                        ...$confirmedNextShift->dayShiftUserIds,
                        ...$confirmedNextShift->lateShiftUserIds,
                        ...$confirmedNextShift->nightShiftUserIds,
                    ],
                    true
                )
            );
        }

        /** @var Collection<int, User> */
        $workNightShiftNurseUser = $canWorkNightShiftUsers
            ->filter(fn (User $user) => $user->role === Role::Nurse)
            ->random(1);

        return $workNightShiftNurseUser->add(
            $canWorkNightShiftUsers
                ->reject(fn (User $user) => $user->id === $workNightShiftNurseUser->first()?->id)
                ->random($numberOfNightShiftUser - 1)
        );
    }

    private function getNumberOfShiftUser(DateTimeInterface $date, string $workStyle): int
    {
        /** @var string[] */
        $closedWeekDays = config('closedDays.closedWeekDays');
        /** @var string[] */
        $holidays = config('closedDays.holidays');
        $isBusinessDay =
            ! in_array(($date)->format('D'), $closedWeekDays, true)
            && ! in_array(($date)->format('Y-m-d'), $holidays, true);

        return match ($workStyle) {
            'day' => $isBusinessDay ? 4 : 3,
            'late' => $isBusinessDay ? 1 : 0,
            'night' => 2,
            default => throw new \InvalidArgumentException('不正な引数です。'),
        };
    }
}
