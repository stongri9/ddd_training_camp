<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use SoftDeletes;
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'shifts';

    /**
     * @var array
     */
    protected $guarded = ['id'];

}
