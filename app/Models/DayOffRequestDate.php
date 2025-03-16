<?php

namespace app\Models;

use Database\Factories\DayOffRequestDateFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $date
 */
class DayOffRequestDate extends Model
{
    // @phpstan-ignore-next-line
    use HasFactory;

    /**
     * The name of the "created at" column.
     *
     * @var string|null
     */
    const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = null;

    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'day_off_requests';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * 複数代入可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = ['date'];

    /**
     * ファクトリー
     *
     * @return DayOffRequestDateFactory
     */
    protected static function newFactory(): DayOffRequestDateFactory
    {
        return DayOffRequestDateFactory::new();
    }
}
