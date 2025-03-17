<?php

namespace app\Repositories\Shift;

use app\Domains\Shift\IShiftRepository;
use app\Domains\Shift\Shift;
use app\Models\Shift as ShiftModel;
use App\Models\ShiftAssignment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ShiftRepository implements IShiftRepository
{
    /**
     * 最新のシフトを1件取得する
     */
    public function getLatestShift(): ?ShiftModel
    {
        return ShiftModel::orderBy('date', 'desc')
            ->first();
    }

    /**
     * まとめてインサートする
     *
     * @param  Collection<int, Shift>  $shiftCollection
     */
    public function insert(Collection $shiftCollection): void
    {
        // トランザクションを開始
        DB::transaction(function () use ($shiftCollection) {
            foreach ($shiftCollection as $shift) {
                // Shiftモデルの作成と保存
                $shiftModel = ShiftModel::query()
                    ->create([
                        'date' => $shift->convertParams()['date'],
                    ]);

                // 日勤のユーザーIDを保存
                foreach ($shift->dayShiftUserIds as $userId) {
                    ShiftAssignment::query()
                        ->create([
                            'shift_id' => $shiftModel->id,
                            'user_id' => $userId,
                            'shift_type' => \app\Domains\Shift\ShiftType::Day->value,
                        ]);
                }

                // 遅番のユーザーIDを保存
                foreach ($shift->lateShiftUserIds as $userId) {
                    ShiftAssignment::query()
                        ->create([
                            'shift_id' => $shiftModel->id,
                            'user_id' => $userId,
                            'shift_type' => \app\Domains\Shift\ShiftType::Late->value,
                        ]);
                }

                // 夜勤のユーザーIDを保存
                foreach ($shift->nightShiftUserIds as $userId) {
                    ShiftAssignment::query()
                        ->create([
                            'shift_id' => $shiftModel->id,
                            'user_id' => $userId,
                            'shift_type' => \app\Domains\Shift\ShiftType::Night->value,
                        ]);
                }
            }
        });
    }

    /**
     * 指定した期間のシフトを取得する
     *
     * @return Collection<int, Shift>
     */
    public function getShiftsByPeriod(\DateTimeInterface $startDate, \DateTimeInterface $endDate): Collection
    {
        return ShiftModel::whereBetween('date', [$startDate, $endDate])
            ->get();
    }

    /**
     * 指定した日付のシフトを取得する
     */
    public function getShiftByDate(\DateTimeInterface $date): ?Shift
    {
        return ShiftModel::where('date', $date)
            ->first();
    }
}
