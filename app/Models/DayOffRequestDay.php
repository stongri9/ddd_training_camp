<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $day_off_request_id
 * @property string $date
 */
class DayOffRequestDay extends Model
{
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
}
