<?php 
namespace App\Domains\Shift;

use DateTimeInterface;
use Illuminate\Support\Collection;

class ShiftFactory {

    public function create(DateTimeInterface $date, Collection $users, Shift $previousShift, Shift|null $confirmedNextShift){
        //休み希望を出しているユーザーは勤務候補のユーザー（$users）から除外する
        //前日夜勤のユーザーは休みにする必要があるので勤務候補のユーザー（$users）から除外する
        $canWorkUsers = $users->filter(
            fn ($user) =>
                !in_array($date, $user->dayOffRequests, true)
                && !in_array($user->id, $previousShift->nightShiftUserIds, true)
        );
        
        $numberOfDayShiftUser = $this->getNumberOfShiftUser($date, 'day');
        // 日勤をきめる
        $canWorkDayShiftUsers = $canWorkUsers->filter(fn ($user) => $user->role !== 'arbeit');
        $canWorkNurseOrAssociateNurseUsers = $canWorkUsers->filter(
            fn ($user) => $user->role === 'associateNurse' || $user->role === 'nurse'
        );
        $workDayShiftNurseOrAssociateNurseUser = $canWorkNurseOrAssociateNurseUsers->random();
        //日勤は、働ける看護師・准看護師から1人と、残りは働ける人たち（先述した1人を除外した）で埋める
        $workDayShiftUsers = $workDayShiftNurseOrAssociateNurseUser
            ->add(
                $canWorkDayShiftUsers
                    ->reject(fn($user)=> $user->id === $workDayShiftNurseOrAssociateNurseUser->id)
                    ->random($numberOfDayShiftUser - 1)
            );
        //日勤で選ばれたユーザーはこのあとの遅番・夜勤の候補となる$canWorkUsersから除外しておく
        $canWorkUsers = $canWorkUsers->reject(
            fn($user) 
                => in_array($user->id, $workDayShiftUsers->pluck('id')->all(), true));

        // 遅番をきめる
        $numberOfLateShiftUser = $this->getNumberOfShiftUser($date, 'late');
        $workLateShiftUsers = new Collection();
        if ($numberOfDayShiftUser > 0) {
            $workLateShiftUsers = $canWorkUsers
                ->filter(fn($user) => $user->role === 'associateNurse' || $user->role === 'nurse')
                ->random($numberOfLateShiftUser);
            //遅番で選ばれたユーザーはこのあとの夜勤の候補となる$canWorkUsersから除外しておく
            $canWorkUsers = $canWorkUsers->reject(fn($user)=> $user->id === $workLateShiftUsers->id);
        }

        // 夜勤をきめる
        $numberOfNightShiftUser = $this->getNumberOfShiftUser($date, 'night');
        $canWorkNightShiftUsers = $canWorkUsers->reject(
            fn($user) => in_array($user->role, ['headNurse', 'chief', 'part'], true)
        );
        //翌日の勤務予定のユーザーを夜勤の候補から除外する
        if (isset($confirmedNextShift)){
            $canWorkNightShiftUsers = $canWorkNightShiftUsers->reject(
                fn ($user) => in_array(
                    $user->id, 
                    [
                        ...$confirmedNextShift->dayShiftUserIds, 
                        ...$confirmedNextShift->lateShiftUserIds, 
                        ...$confirmedNextShift->nightShiftUserIds
                    ], 
                    true
                )
            );
        }
        $workNightShiftNurseUser = $canWorkNightShiftUsers
            ->filter(fn ($user) => $user->role === 'nurse')
            ->random();
        //夜勤は、働ける看護師から1人と、残りは働ける人たち（先述した1人を除外した）で埋める
        $workNightShiftUsers = $workNightShiftNurseUser
            ->add(
                $canWorkNightShiftUsers
                    ->reject(fn($user) => $user->id === $workNightShiftNurseUser->id)
                    ->random($numberOfNightShiftUser - 1)
            );

        return Shift::create(
            $date->format('Y-m-d'), 
            $workDayShiftUsers->pluck('id')->all(), 
            $workLateShiftUsers->pluck('id')->all(), 
            $workNightShiftUsers->pluck('id')->all()
        );
    }

    private function getNumberOfShiftUser(DateTimeInterface $date, string $workStyle): int
    {
        $isBusinessDay = 
            !in_array(($date)->format('D'), config('closedDays.closedWeekDays'), true)
            && !in_array(($date)->format('Y-m-d'), config('closedDays.holidays'), true);
        return match ($workStyle) {
            'day' => $isBusinessDay ? 4 : 3,
            'late' => $isBusinessDay ? 1 : 0,
            'night' => 2,
        };
    }
}