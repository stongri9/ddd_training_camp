<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\ShiftFactory;

/**
 * @property int $id    
 * @property string $date
 */
class Shift extends Model
{
    /** @use HasFactory<\Database\Factories\ShiftFactory> */
    use HasFactory, SoftDeletes;

    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'shifts';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @return ShiftFactory
     */
    protected static function newFactory(): ShiftFactory
    {
        return ShiftFactory::new();
    }
}
