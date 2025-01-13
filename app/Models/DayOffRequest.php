<?php

namespace App\Models;

use Database\Factories\DayOffRequestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayOffRequest extends Model
{
    use HasFactory;

    /**
     * The name of the "created at" column.
     *
     * @var string|null
     */
    const CREATED_AT = null;

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

    protected static function newFactory()
    {
        return DayOffRequestFactory::new();
    }
}
