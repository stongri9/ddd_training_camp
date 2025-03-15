<?php

namespace app\Domains\Shift;

use DateTimeInterface;
use Illuminate\Support\Collection;

class ShiftFactory
{
    public function create(DateTimeInterface $date, Collection $users, Shift $previousShift, ?Shift $confirmedNextShift)
    {
        $canWorkUsers = $users->filter(
            fn ($user) => ! in_array($date, $user->dayOffRequests, true)
                && ! in_array($user->id, $previousShift->nightShiftUserIds, true)
        );

        $workDayShiftUsers = $this->determineDayShiftUsers($date, $canWorkUsers);
        $canWorkUsers = $canWorkUsers->reject(fn ($user) => in_array($user->id, $workDayShiftUsers->pluck('id')->all(), true));

        $workLateShiftUsers = $this->determineLateShiftUsers($date, $canWorkUsers);
        $canWorkUsers = $canWorkUsers->reject(fn ($user) => in_array($user->id, $workLateShiftUsers->pluck('id')->all(), true));

        $workNightShiftUsers = $this->determineNightShiftUsers($date, $canWorkUsers, $confirmedNextShift);

        return Shift::create(
            $date->format('Y-m-d'),
            $workDayShiftUsers->pluck('id')->all(),
            $workLateShiftUsers->pluck('id')->all(),
            $workNightShiftUsers->pluck('id')->all()
        );
    }

    private function determineDayShiftUsers(DateTimeInterface $date, Collection $canWorkUsers): Collection
    {
        $numberOfDayShiftUser = $this->getNumberOfShiftUser($date, 'day');
        $canWorkNurseOrAssociateNurseUsers = $canWorkUsers->filter(
            fn ($user) => in_array($user->role, ['associateNurse', 'nurse'], true)
        );
        $workDayShiftNurseOrAssociateNurseUser = $canWorkNurseOrAssociateNurseUsers->random();

        return $workDayShiftNurseOrAssociateNurseUser->add(
            $canWorkUsers
                ->reject(fn ($user) => $user->id === $workDayShiftNurseOrAssociateNurseUser->id)
                ->random($numberOfDayShiftUser - 1)
        );
    }

    private function determineLateShiftUsers(DateTimeInterface $date, Collection $canWorkUsers): Collection
    {
        $numberOfLateShiftUser = $this->getNumberOfShiftUser($date, 'late');
        if ($numberOfLateShiftUser > 0) {
            return $canWorkUsers
                ->filter(fn ($user) => in_array($user->role, ['associateNurse', 'nurse'], true))
                ->random($numberOfLateShiftUser);
        }

        return new Collection;
    }

    private function determineNightShiftUsers(DateTimeInterface $date, Collection $canWorkUsers, ?Shift $confirmedNextShift): Collection
    {
        $numberOfNightShiftUser = $this->getNumberOfShiftUser($date, 'night');
        $canWorkNightShiftUsers = $canWorkUsers->reject(
            fn ($user) => in_array($user->role, ['headNurse', 'chief', 'part'], true)
        );

        if (isset($confirmedNextShift)) {
            $canWorkNightShiftUsers = $canWorkNightShiftUsers->reject(
                fn ($user) => in_array(
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

        $workNightShiftNurseUser = $canWorkNightShiftUsers
            ->filter(fn ($user) => $user->role === 'nurse')
            ->random();

        return $workNightShiftNurseUser->add(
            $canWorkNightShiftUsers
                ->reject(fn ($user) => $user->id === $workNightShiftNurseUser->id)
                ->random($numberOfNightShiftUser - 1)
        );
    }

    private function getNumberOfShiftUser(DateTimeInterface $date, string $workStyle): int
    {
        $isBusinessDay =
            ! in_array(($date)->format('D'), config('closedDays.closedWeekDays'), true)
            && ! in_array(($date)->format('Y-m-d'), config('closedDays.holidays'), true);

        return match ($workStyle) {
            'day' => $isBusinessDay ? 4 : 3,
            'late' => $isBusinessDay ? 1 : 0,
            'night' => 2,
        };
    }
}
