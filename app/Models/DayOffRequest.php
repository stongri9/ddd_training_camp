<?php

namespace app\Models;

use Database\Factories\DayOffRequestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property HasMany<DayOffRequestDay, DayOffRequest> $day_off_request_days
 */
class DayOffRequest extends Model
{
    /** @use HasFactory<\Database\Factories\DayOffRequestFactory> */
    use HasFactory;

    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'day_off_requests';

    /**
     * 複数代入可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'date'];

    /**
     * リレーション
     *
     * @return HasMany<DayOffRequestDay, DayOffRequest>
     */
    public function day_off_request_days(): HasMany
    {
        /** @var HasMany<DayOffRequestDay, DayOffRequest> */
        return $this->hasMany(DayOffRequestDay::class, 'day_off_request_id', 'id');
    }

    protected static function newFactory(): DayOffRequestFactory
    {
        return DayOffRequestFactory::new();
    }
}
