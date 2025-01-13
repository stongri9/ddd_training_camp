<?php

namespace App\UseCases\Shift;

use App\Domains\Shift\IShiftRepository;
use App\Domains\User\IUserRepository;
use App\Domains\Shift\Shift;
use App\Domains\Shift\CreateShiftSpecification;
use DateTime;
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
                $users = $this->userRepository->findAll();
                $date = new DateTime($createUseCaseDto->startDate);
                $endDate = new DateTimeImmutable($createUseCaseDto->endDate);
                $previousShift = $this->shiftRepository->getShiftByDate($date->modify('-1 day'));
                //開始日〜終了日まで1日ずつ加算しながら日ごとのシフトを作成する
                for(; $date->diff($endDate)->d !== 0; $date->modify('+1 day')) {
                    /************************************************
                     * ここから
                     ***********************************************/
                    //前日夜勤のユーザーは翌日休みなので勤務候補のユーザー（$users）から除外する
                    //すでにこのfor文内で前日のシフトを作っているなら、そこから前日分のシフトを取得する
                    if ($shiftCollection->isNotEmpty()) {
                        $previousShift = $shiftCollection->search(
                            fn ($shift) => $shift->date->value === $date
                        );
                    }
                    $canWorkUsers = $users->filter(
                        fn ($user) => 
                            !in_array($date, $user->dayOffRequests, true) 
                            && !in_array($user->id, $previousShift->nightShiftUserIds, true)
                        );
                    
                    $isBusinessDay = 
                        !in_array(($date)->format('D'), config('closedDays.closedWeekDays'), true)
                        && !in_array(($date)->format('Y-m-d'), config('closedDays.holidays'), true);
                    
                    $numberOfDayShiftUser = $isBusinessDay ? 4 : 3 ;
                    
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
                    if ($isBusinessDay) {
                        $workLateShiftUsers = $canWorkUsers
                            ->filter(fn($user) => $user->role === 'associateNurse' || $user->role === 'nurse')
                            ->random(1);
                        //遅番で選ばれたユーザーはこのあとの夜勤の候補となる$canWorkUsersから除外しておく
                        $canWorkUsers = $canWorkUsers->reject(fn($user) 
                            => in_array($user, $workLateShiftUsers->pluck('id')->all(), true)
                        );
                    }

                    // 夜勤をきめる
                    $numberOfNightShiftUser = 2;
                    $canWorkNightShiftUsers = $canWorkUsers->reject(
                        fn($user) => in_array($user->role, ['headNurse', 'chief', 'part'], true)
                    );
                    //これがfor文の最終ループだった場合、翌日勤務予定のユーザーを夜勤の候補から除外する
                    //最終ループでない場合は、次のループで翌日シフトを生成する際に前日の夜勤は除外するため、翌日を気にする必要がない
                    if ($date->diff($endDate)->d === 0){
                        $nextShift = $this->shiftRepository->getShiftByDate($date->modify('+1 day'));
                        //翌日のシフトが未作成の場合も、翌日を気にする必要はない
                        if (isset($nextShift)){
                            $canWorkNightShiftUsers = $canWorkNightShiftUsers->reject(
                                fn ($user) => in_array(
                                    $user->id, 
                                    [
                                        ...$nextShift->dayShiftUserIds, 
                                        ...$nextShift->lateShiftUserIds, 
                                        ...$nextShift->nightShiftUserIds
                                    ], 
                                    true
                                    )
                                );
                        }
                    }
                    $workNightShiftNurseUser = $canWorkUsers
                        ->filter(fn ($user) => $user->role === 'nurse')
                        ->random();
                    //夜勤は、働ける看護師から1人と、残りは働ける人たち（先述した1人を除外した）で埋める
                    $workNightShiftUsers = $workNightShiftNurseUser
                        ->add(
                            $canWorkNightShiftUsers
                                ->reject(fn($user) => $user->id === $workNightShiftNurseUser->id)
                                ->random($numberOfNightShiftUser - 1)
                        );

                    $entity = Shift::create(
                        $date->format('Y-m-d'), 
                        $workDayShiftUsers->pluck('id')->all(), 
                        $workLateShiftUsers->pluck('id')->all(), 
                        $workNightShiftUsers->pluck('id')->all()
                    );
                    /************************************************
                     * ここまでファクトリーかな！
                     ***********************************************/

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