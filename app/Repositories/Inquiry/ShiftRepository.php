<?php

namespace app\Repositories\Shift;

use App\Domains\Shift\IShiftRepository;
use App\Domains\Shift\Shift;
use App\Models\Shift as ShiftModel;
use Illuminate\Support\Collection;

class ShiftRepository implements IShiftRepository
{
    /**
     * 最新のシフトを1件取得
     *
     * @return \App\Models\Shift
     */
    public function getLatestShift(): ?Shift
    {
        return ShiftModel::orderBy('date', 'desc')
            ->first();
    }

    /**
     * インサート処理
     */
    public function create(Shift $shift): void
    {
        ShiftModel::create($shift->convertParams());
    }

    /**
     * まとめてインサート
     */
    public function insert(Collection $shiftCollecton): void
    {
        ShiftModel::insert($shiftCollecton->toArray());
    }

    /**
     * 指定した期間のシフトを返却します
     *
     * @param  DateTimeInterface  $startDate
     * @param  DateTimeInterface  $endDate
     */
    public function getShiftsByPeriod(\DateTimeInterface $startDate, \DateTimeInterface $endDate): Collection
    {
        return ShiftModel::whereBetween('date', [$startDate, $endDate])
            ->get();
    }

    /**
     * 指定した日付のシフトを返却します
     *
     * @param  DateTimeInterface  $date
     */
    public function getShiftByDate(\DateTimeInterface $date): ?Shift
    {
        return ShiftModel::where('date', $date)
            ->get();
    }
}
