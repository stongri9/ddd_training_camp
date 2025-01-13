<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayOffRequest extends Model
{
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
}
