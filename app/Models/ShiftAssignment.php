<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftAssignment extends Model
{
    protected $fillable = ['shift_id', 'user_id', 'shift_type'];
}
