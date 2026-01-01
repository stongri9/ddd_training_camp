<?php

namespace app\Models;

use App\Models\ShiftAssignment;
use Database\Factories\ShiftFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

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
     * @return HasMany<ShiftAssignment, Shift>
     */
    public function shiftAssignments(): HasMany
    {
        return $this->hasMany(ShiftAssignment::class, 'shift_id', 'id');
    }

    /**
     * @return HasOne<ShiftPublishEvent, Shift>
     */
    public function shiftPublishedEvent(): HasOne
    {
        return $this->hasOne(ShiftPublishEvent::class, 'shift_id', 'id');
    }

    protected static function newFactory(): ShiftFactory
    {
        return ShiftFactory::new();
    }
}
