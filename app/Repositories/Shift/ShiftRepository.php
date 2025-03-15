<?php

namespace app\Repositories\Shift;

use app\Domains\Shift\IShiftRepository;
use app\Domains\Shift\Shift;
use app\Models\Shift as ShiftModel;
use Illuminate\Support\Collection;

class ShiftRepository implements IShiftRepository
{
    /**
     * 最新のシフトを1件取得する
     */
    public function getLatestShift(): ?Shift
    {
        return ShiftModel::orderBy('date', 'desc')
            ->first();
    }

    /**
     * インサートする
     */
    public function create(Shift $shift): void
    {
        ShiftModel::create($shift->convertParams());
    }

    /**
     * まとめてインサートする
     *
     * @param  Collection<int, Shift>  $shiftCollecton
     */
    public function insert(Collection $shiftCollecton): void
    {
        ShiftModel::insert($shiftCollecton->toArray());
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
