<?php

namespace App\UseCases\Shift;

use App\Domains\Shift\IShiftRepository;
use App\Domains\User\IUserRepository;
use App\Domains\Shift\Shift;
use App\Domains\Shift\CreateShiftSpecification;
use DateTimeImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CreateUseCase {
    public function __construct(
        private readonly IShiftRepository $shiftRepository,
        private readonly IUserRepository $userRepository,
        private readonly CreateShiftSpecification $createShiftSpecification,
    ) {}
        
    public function __invoke(CreateUseCaseDto $createUseCaseDto): void
    {
        DB::beginTransaction();
        try{
            $shiftCollection = new Collection();
            try{
                //開始日〜終了日まで1日ずつ加算しながら日ごとのシフトを作成する
                for($date = $createUseCaseDto->startDate; new DateTimeImmutable($date) <= new DateTimeImmutable($createUseCaseDto->endDate);  $date=(new DateTimeImmutable($createUseCaseDto->startDate))->modify('+1 day')->format('Y-m-d')){
                    $users = $this->userRepository->findAll();
                    //前日夜勤のユーザーは翌日休みなので勤務候補のユーザー（$users）から除外する
                    $previousShift = $shiftCollection->search(function ($shift) use ($date) {
                        //すでにこのfor文内で前日のシフトを作っているなら、そこから前日分のシフトを取得する
                        return $shift->date->value === (new DateTimeImmutable($date))->format('Y-m-d');
                    });
                    if ($previousShift === false) {
                        //このfor文で前日のシフトを作っていない場合、DBから前日のシフトを取得する
                        $previousShift = $this->shiftRepository->getShiftByDate((new DateTimeImmutable($date))->modify('-1 day'));
                    }
                    $canWorkUsers = $users->reject(function ($user) use ($date, $previousShift) {
                        return in_array($date, $user->dayOffRequests, true) || in_array($user->id, $previousShift->nightShiftUserIds, true);
                    });
                    
                    $isBusinessDay = !in_array((new DateTimeImmutable($date))->format('D'), config('closedDays.closedWeekDays'), true) && !in_array((new DateTimeImmutable($date))->format('Y-m-d'), config('closedDays.holidays'), true);
                    
                    // 日勤をきめる
                    $numberOfDayShiftUser = $isBusinessDay ? 4 : 3 ;
                    $canWorkDayShiftUsers = $canWorkUsers->filter(function ($user) {
                        return $user->role != 'arbeit';
                    });
                    $canWorkNurseOrAssociateNurseUsers = $canWorkUsers->filter(function ($user) {
                        return $user->role === 'associateNurse' || $user->role === 'nurse';
                    });
                    $workDayShiftNurseOrAssociateNurseUser = $canWorkNurseOrAssociateNurseUsers->random();
                    //日勤は、働ける看護師・准看護師から1人と、残りは働ける人たち（先述した1人を除外した）で埋める
                    $workDayShiftUsers = $workDayShiftNurseOrAssociateNurseUser
                        ->add(
                            $canWorkDayShiftUsers
                                ->reject(function ($user) use ($workDayShiftNurseOrAssociateNurseUser) {
                                    return $user->id === $workDayShiftNurseOrAssociateNurseUser->id;
                                })->random($numberOfDayShiftUser - 1)
                        );
                    //日勤で選ばれたユーザーはこのあとの遅番・夜勤の候補となる$canWorkUsersから除外しておく
                    $canWorkUsers = $canWorkUsers->reject(function ($user) use ($workDayShiftUsers) {
                        return in_array($user, $workDayShiftUsers->pluck('id')->all(), true);
                    });

                    // 遅番をきめる
                    $workLateShiftUsers = $isBusinessDay ? $canWorkUsers->filter(function ($user) {
                        return $user->role === 'associateNurse' || $user->role === 'nurse';
                    })->random(1) : new Collection ;
                    //遅番で選ばれたユーザーはこのあとの夜勤の候補となる$canWorkUsersから除外しておく
                    $canWorkUsers = $canWorkUsers->reject(function ($user) use ($workLateShiftUsers) {
                        return in_array($user, $workLateShiftUsers->pluck('id')->all(), true);
                    });

                    // 夜勤をきめる
                    $numberOfNightShiftUser = 2;
                    $canWorkNightShiftUsers = $canWorkUsers->reject(function ($user) {
                        return in_array($user->role, ['headNurse', 'chief', 'part'], true);
                    });
                    //これがfor文の最終ループだった場合、翌日勤務予定のユーザーを夜勤の候補から除外する
                    //最終ループでない場合は、次のループで翌日シフトを生成する際に前日の夜勤は除外するため、翌日を気にする必要がない
                    if (new DateTimeImmutable($date) === new DateTimeImmutable($createUseCaseDto->endDate)){
                        $nextShift = $this->shiftRepository->getShiftByDate((new DateTimeImmutable($date))->modify('+1 day'));
                        //翌日のシフトが未作成の場合も、翌日を気にする必要はない
                        if(isset($nextShift)){
                            $canWorkNightShiftUsers = $canWorkNightShiftUsers->reject(function ($user) use ($nextShift) {
                                return in_array($user->id, [...$nextShift->dayShiftUserIds, ...$nextShift->lateShiftUserIds, ...$nextShift->nightShiftUserIds], true);
                            });
                        }
                    }
                    $canWorkNurseUsers = $canWorkUsers->filter(function ($user) {
                        return $user->role === 'nurse';
                    });
                    $workNightShiftNurseUser = $canWorkNurseUsers->random();
                    //夜勤は、働ける看護師から1人と、残りは働ける人たち（先述した1人を除外した）で埋める
                    $workNightShiftUsers = $workNightShiftNurseUser
                        ->add(
                            $canWorkNightShiftUsers
                                ->reject(function ($user) use ($workNightShiftNurseUser) {
                                    return $user->id === $workNightShiftNurseUser->id;
                                })->random($numberOfNightShiftUser - 1)
                        );

                    $entity = Shift::create($date, $workDayShiftUsers->pluck('id')->all(), $workLateShiftUsers->pluck('id')->all(), $workNightShiftUsers->pluck('id')->all()); 
                    $shiftCollection->add($entity);
                }
            } catch (\Exception $e) {
                throw $e;
            }
            $errors =[];
            foreach($shiftCollection as $shift){
                $errors = [
                    ...$errors,
                    ...$this->createShiftSpecification->getViolations(
                    $shift->date,
                    $shift->dayShiftUserIds,
                    $shift->lateShiftUserIds,
                    $shift->nightShiftUserIds,
                    )
                ];
            }
            if ($errors) {
                throw new \InvalidArgumentException(implode(PHP_EOL, $errors));
            }
            $this->shiftRepository->createAll($shiftCollection);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}