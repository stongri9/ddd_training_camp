<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
    use SoftDeletes;

    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'inquiries';

    /**
     * @var array
     */
    protected $guarded = ['id'];
}
