<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
/**
 * @property int $id
 * @property string $start_date
 * @property string $end_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ShiftPublishEvent extends Model
{
    protected $table = 'shift_publish_events';

    /**
     * @var string[]
     */
    protected $guarded = ['id'];
}
