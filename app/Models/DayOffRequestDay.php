<?php

namespace app\Models;

use Database\Factories\DayOffRequestDayFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $day_off_request_id
 * @property string $date
 */
class DayOffRequestDay extends Model
{
    /** @use HasFactory<\Database\Factories\DayOffRequestDayFactory> */
    use HasFactory;

    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'day_off_request_days';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * リレーション
     *
     * @return BelongsTo<DayOffRequest, DayOffRequestDay>
     */
    public function day_off_request(): BelongsTo
    {
        /** @var BelongsTo<DayOffRequest, DayOffRequestDay> */
        return $this->belongsTo(DayOffRequest::class, 'day_off_request_id', 'id');
    }

    protected static function newFactory(): DayOffRequestDayFactory
    {
        return DayOffRequestDayFactory::new();
    }
}
