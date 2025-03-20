<?php

namespace App\Models;

use app\Domains\Shift\ShiftType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShiftAssignment extends Model
{
    protected $fillable = ['shift_id', 'user_id', 'shift_type'];


    protected function shiftType(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ShiftType::from($value),
        );
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
