<?php

namespace app\Models;

use Database\Factories\DayOffRequestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $date
 */
class DayOffRequest extends Model
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
     * 複数代入可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'date'];

    protected static function newFactory(): DayOffRequestFactory
    {
        return DayOffRequestFactory::new();
    }
}
